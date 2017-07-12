<?php

namespace Alpha\VisitorTrackingBundle\EventListener;

use Alpha\VisitorTrackingBundle\Entity\Lifetime;
use Alpha\VisitorTrackingBundle\Entity\PageView;
use Alpha\VisitorTrackingBundle\Entity\Session;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class VisitorTrackingSubscriber
 * @package Alpha\VisitorTrackingBundle\EventListener
 *
 * Tracks the source of a session and each pageview in that session. Primary use of this is to be able to see the path through our site each
 */
class VisitorTrackingSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Lifetime
     */
    protected $lifetime;

    /**
     * @var array
     */
    protected $utmCodes = [
        "utm_source",
        "utm_medium",
        "utm_campaign",
        "utm_term",
        "utm_content"
    ];

    const COOKIE_LIFETIME = "lifetime";
    const COOKIE_SESSION = "session";

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (substr($request->get("_route"), 0, 1) == "_") {
            //these are requests for assets/symfony toolbar etc. Not relevant for our tracking
            return;
        }

        if ($request->cookies->has(self::COOKIE_SESSION) and !$this->requestHasUTMParameters($request)) {
            $this->session = $this->em->getRepository("AlphaVisitorTrackingBundle:Session")->find($request->cookies->get(self::COOKIE_SESSION));

            if ($this->session instanceof Session) {
                $this->lifetime = $this->session->getLifetime();
            } else {
                $this->generateSessionAndLifetime($request);
            }
        } else {
            $this->generateSessionAndLifetime($request);
        }
    }

    /**
     * @param FilterResponseEvent $event
     * @throws \Doctrine\ORM\ORMException
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (false === $this->session instanceof Session) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();
        if (substr($request->get("_route"), 0, 1) == "_" or ($response instanceof RedirectResponse)) {
            //these are requests for assets/symfony toolbar etc. Not relevant for our tracking
            return;
        }

        $pageView = new PageView();
        $pageView->setUrl($request->getUri());

        $this->session->addPageView($pageView);

        try {
            $this->em->flush();
        } catch (\Doctrine\ORM\ORMException $e) {
            if (!$this->em->isOpen()) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration()
                );
                $this->em->flush();
            } else {
                throw $e;
            }
        }

        if ($this->requestHasUTMParameters($request)) {
            $this->setUTMSessionCookies($request, $response);
        }

        if (!$request->cookies->has(self::COOKIE_LIFETIME)) {
            $response->headers->setCookie(new Cookie(self::COOKIE_LIFETIME, $this->lifetime->getId(), new \DateTime("+2 years"), "/", null, false, false));
        }
        //no session cookie set OR session cookie value != current session ID
        if (!$request->cookies->has(self::COOKIE_SESSION) or ($request->cookies->get(self::COOKIE_SESSION) != $this->session->getId())) {
            $response->headers->setCookie(new Cookie(self::COOKIE_SESSION, $this->session->getId(), 0, "/", null, false, false));
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function requestHasUTMParameters(Request $request)
    {
        foreach ($this->utmCodes as $code) {
            if ($request->query->has($code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    protected function setUTMSessionCookies(Request $request, Response $response)
    {
        foreach ($this->utmCodes as $code) {
            $response->headers->clearCookie($code);
            if ($request->query->has($code)) {
                $response->headers->setCookie(new Cookie($code, $request->query->get($code), 0, "/", null, false, false));
            }
        }
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return Lifetime
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => ['onKernelResponse', 1024],
            KernelEvents::REQUEST => ["onKernelRequest", 16]
        );
    }

    /**
     * @param Request $request
     * @throws \Doctrine\ORM\ORMException
     */
    private function generateSessionAndLifetime(Request $request)
    {
        $lifetime = false;
        if ($request->cookies->has(self::COOKIE_LIFETIME)) {
            $lifetime = $this->em->getRepository("AlphaVisitorTrackingBundle:Lifetime")->find($request->cookies->get(self::COOKIE_LIFETIME));
        }
        if (!$lifetime) {
            $lifetime = new Lifetime();
            $this->em->persist($lifetime);
        }
        $session = new Session();
        $session->setIp($request->getClientIp() ?: "");
        $session->setReferrer($request->headers->get("Referer") ?: "");
        $session->setUserAgent($request->headers->get("User-Agent") ?: "");
        $session->setQueryString($request->getQueryString() ?: "");
        $session->setLoanTerm($request->query->get("y") ?: "");
        $session->setRepApr($request->query->has("r") ? hexdec($request->query->get("r")) / 100 : "");
        foreach ($this->utmCodes as $code) {
            $method = "set" . \Doctrine\Common\Inflector\Inflector::classify($code);
            $session->$method($request->query->get($code) ?: "");
        }
        $lifetime->addSession($session);

        try {
            $this->em->flush();
        } catch (\Doctrine\ORM\ORMException $e) {
            if (!$this->em->isOpen()) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration()
                );
                $this->em->flush();
            } else {
                throw $e;
            }
        }

        $this->session = $session;
        $this->lifetime = $lifetime;
    }
}
