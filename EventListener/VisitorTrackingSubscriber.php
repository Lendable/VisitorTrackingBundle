<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 17/04/14
 * Time: 17:11
 */

namespace Alpha\VisitorTrackingBundle\EventListener;

use Alpha\VisitorTrackingBundle\Entity\Lifetime;
use Alpha\VisitorTrackingBundle\Entity\PageView;
use Alpha\VisitorTrackingBundle\Entity\Session;
use Doctrine\Common\Inflector\Inflector;
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

    protected $utmCodes = [
        "utm_source",
        "utm_medium",
        "utm_campaign",
        "utm_term",
        "utm_content"
    ];

    const COOKIE_LIFETIME = "lifetime";
    const COOKIE_SESSION = "session";

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (substr($request->get("_route"), 0, 1) == "_") {
            //these are requests for assets/symfony toolbar etc. Not relevant for our tracking
            return;
        }

        if ($request->cookies->has(self::COOKIE_SESSION)) {
            $this->session = $this->em->getRepository("AlphaVisitorTrackingBundle:Session")->find($request->cookies->get(self::COOKIE_SESSION));

            if ($this->session instanceof Session && (!$this->requestHasUTMParameters($request) || $this->sessionMatchesRequestParameters($request))) {
                $this->lifetime = $this->session->getLifetime();
            } else {
                $this->generateSessionAndLifetime($request);
            }
        } else {
            $this->generateSessionAndLifetime($request);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (false === $this->session instanceof Session) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

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

        if (substr($request->get("_route"), 0, 1) == "_" or ($response instanceof RedirectResponse)) {
            //these are requests for assets/symfony toolbar etc. Not relevant for our tracking
            return;
        }

        $pageView = new PageView();
        $pageView->setUrl($request->getUri());

        $this->session->addPageView($pageView);

        $this->em->flush($this->session);
    }

    protected function requestHasUTMParameters(Request $request)
    {
        foreach ($this->utmCodes as $code) {
            if ($request->query->has($code)) {
                return true;
            }
        }

        return false;
    }

    protected function setUTMSessionCookies(Request $request, Response $response)
    {
        foreach ($this->utmCodes as $code) {
            $response->headers->clearCookie($code);
            if ($request->query->has($code)) {
                $response->headers->setCookie(new Cookie($code, $request->query->get($code), 0, "/", null, false, false));
            }
        }
    }

    private function sessionMatchesRequestParameters(Request $request)
    {
        foreach ($this->utmCodes as $code) {
            $method = 'get'.Inflector::classify($code);
            if ($request->query->get($code) != $this->session->$method()) {
                return false;
            }
        }

        return true;
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

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => ['onKernelResponse', 1024],
            KernelEvents::REQUEST => ["onKernelRequest", 16]
        );
    }

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

        $this->em->flush();

        $this->session = $session;
        $this->lifetime = $lifetime;
    }
}
