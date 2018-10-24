<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\EventListener;

use Alpha\VisitorTrackingBundle\Entity\Lifetime;
use Alpha\VisitorTrackingBundle\Entity\PageView;
use Alpha\VisitorTrackingBundle\Entity\Session;
use Alpha\VisitorTrackingBundle\Storage\SessionStore;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Tracks the source of a session and each page view in that session.
 */
class VisitorTrackingSubscriber implements EventSubscriberInterface
{
    public const COOKIE_LIFETIME = 'lifetime';

    public const COOKIE_SESSION = 'session';

    protected const UTM_CODES = [
        'utm_source' => 'utm_source',
        'utm_medium' => 'utm_medium',
        'utm_campaign' => 'utm_campaign',
        'utm_term' => 'utm_term',
        'utm_content' => 'utm_content',
    ];

    protected const COOKIE_SESSION_TTL = '+2 years';

    private $entityManager;

    private $sessionStore;

    private $firewallBlacklist;

    private $firewallMap;

    public function __construct(
        EntityManager $entityManager,
        SessionStore $sessionStore,
        array $firewallBlacklist,
        FirewallMap $firewallMap
    ) {
        $this->entityManager = $entityManager;
        $this->sessionStore = $sessionStore;
        $this->firewallBlacklist = $firewallBlacklist;
        $this->firewallMap = $firewallMap;
    }

    public static function getSubscribedEvents(): iterable
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 1024],
            KernelEvents::REQUEST => ['onKernelRequest', 16],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if ($this->isBlacklistedFirewall($request) || !$this->shouldActOnRequest($request)) {
            return;
        }

        if ($request->cookies->has(self::COOKIE_SESSION)) {
            $session = $this->entityManager->getRepository(Session::class)->find($request->cookies->get(self::COOKIE_SESSION));

            if ($session instanceof Session && (!$this->requestHasUTMParameters($request) || $this->sessionMatchesRequestParameters($request))) {
                $this->sessionStore->setSession($session);
            } else {
                $this->generateSessionAndLifetime($request);
            }
        } else {
            $this->generateSessionAndLifetime($request);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event): void
    {
        if ($this->isBlacklistedFirewall($event->getRequest())) {
            return;
        }

        $session = $this->sessionStore->getSession();

        if (!$session instanceof Session) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        if (!$request->cookies->has(self::COOKIE_LIFETIME)) {
            \assert($session->getLifetime() instanceof Lifetime);
            $response->headers->setCookie(new Cookie(self::COOKIE_LIFETIME, $session->getLifetime()->getId(), new \DateTime('+2 years'), '/', null, false, false));
        }

        if (!$request->cookies->has(self::COOKIE_SESSION) || ($request->cookies->get(self::COOKIE_SESSION) !== $session->getId())) {
            $response->headers->setCookie(new Cookie(self::COOKIE_SESSION, $session->getId(), 0, '/', null, false, false));
        }

        if (!$this->shouldActOnRequest($request)) {
            return;
        }

        $pageView = new PageView();
        $pageView->setUrl($request->getUri());
        $session->addPageView($pageView);

        $this->entityManager->flush($session);
    }

    protected function requestHasUTMParameters(Request $request): bool
    {
        foreach (static::UTM_CODES as $code) {
            if ($request->query->has($code)) {
                return true;
            }
        }

        return false;
    }

    protected function setUTMSessionCookies(Request $request, Response $response): void
    {
        foreach (self::UTM_CODES as $code) {
            $response->headers->clearCookie($code);
            if ($request->query->has($code)) {
                $response->headers->setCookie(new Cookie($code, $request->query->get($code), 0, '/', null, false, false));
            }
        }
    }

    private function generateSessionAndLifetime(Request $request): void
    {
        $lifetime = null;

        if ($request->cookies->has(self::COOKIE_LIFETIME)) {
            $lifetime = $this->entityManager->getRepository(Lifetime::class)->find($request->cookies->get(self::COOKIE_LIFETIME));
        }

        if (!$lifetime instanceof Lifetime) {
            $lifetime = new Lifetime();
            $this->entityManager->persist($lifetime);
            $this->entityManager->flush($lifetime);
        }

        $session = new Session();
        $this->entityManager->persist($session);
        $session->setIp($request->getClientIp() ?: '');
        $referer = $request->headers->get('Referer');
        $session->setReferrer(\is_string($referer) ? $referer : '');
        $userAgent = $request->headers->get('User-Agent');
        $session->setUserAgent(\is_string($userAgent) ? $userAgent : '');
        $session->setQueryString($request->getQueryString() ?: '');
        $session->setLoanTerm($request->query->get('y') ?: '');
        $session->setRepApr($request->query->has('r') ? (string) (\hexdec($request->query->get('r')) / 100) : '');

        foreach (self::UTM_CODES as $code) {
            $method = 'set'.Inflector::classify($code);
            $session->$method($request->query->get($code) ?: '');
        }

        $lifetime->addSession($session);

        $this->entityManager->flush($session);

        $this->sessionStore->setSession($session);
    }

    private function shouldActOnRequest(Request $request, ?Response $response = null): bool
    {
        $route = $request->attributes->get('_route');

        if ($response instanceof RedirectResponse || (!\is_string($route) || 0 === \strpos($route, '_'))) {
            //these are requests for assets/symfony toolbar etc. Not relevant for our tracking
            return false;
        }

        return true;
    }

    private function isBlacklistedFirewall(Request $request): bool
    {
        $firewallConfig = $this->firewallMap->getFirewallConfig($request);

        return $firewallConfig !== null && \in_array($firewallConfig->getName(), $this->firewallBlacklist, true);
    }

    private function sessionMatchesRequestParameters(Request $request): bool
    {
        $session = $this->sessionStore->getSession();

        if (!$session instanceof Session) {
            return false;
        }

        foreach (self::UTM_CODES as $code) {
            $method = 'get'.Inflector::classify($code);

            if ($request->query->get($code, '') !== $session->$method()) {
                return false;
            }
        }

        return true;
    }
}
