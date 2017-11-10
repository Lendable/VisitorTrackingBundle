<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Storage;

use Alpha\VisitorTrackingBundle\Entity\Lifetime;
use Alpha\VisitorTrackingBundle\Entity\Session;

class SessionStore
{
    /**
     * @var Session|null
     */
    private $session;

    public function clear(): void
    {
        $this->session = null;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function getLifetime(): ?Lifetime
    {
        $session = $this->getSession();

        if ($session === null) {
            return null;
        }

        return $session->getLifetime();
    }
}
