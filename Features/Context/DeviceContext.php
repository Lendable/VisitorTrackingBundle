<?php

namespace Alpha\VisitorTrackingBundle\Features\Context;

use Alpha\VisitorTrackingBundle\Entity\Session;
use Alpha\VisitorTrackingBundle\EventListener\VisitorTrackingSubscriber;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityManagerInterface;
use Alpha\VisitorTrackingBundle\Entity\Lifetime;

class DeviceContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    private $entityManager;

    private $utmCodes = [
        "utm_source",
        "utm_medium",
        "utm_campaign",
        "utm_term",
        "utm_content"
    ];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Given /^a user session exists$/
     */
    public function theCookieHasTheValue()
    {
        $session = new Session();
        $session->setIp('127.0.0.1');
        $session->setReferrer("");
        $session->setUserAgent("");
        $session->setQueryString("");
        $session->setLoanTerm("");
        $session->setRepApr("");
        foreach ($this->utmCodes as $code) {
            $method = "set" . Inflector::classify($code);
            $session->$method("");
        }

        $lifetime = new Lifetime();
        $lifetime->addSession($session);
        $lifetime->setSeed(12356);
        $session->setLifetime($lifetime);

        $this->entityManager->persist($lifetime);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        $this->getSession()->setCookie(VisitorTrackingSubscriber::COOKIE_SESSION, $session->getId());
    }
}
