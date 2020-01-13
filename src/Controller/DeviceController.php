<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Controller;

use Alpha\VisitorTrackingBundle\Entity\Device;
use Alpha\VisitorTrackingBundle\Entity\Session;
use Alpha\VisitorTrackingBundle\Manager\DeviceFingerprintManager;
use Alpha\VisitorTrackingBundle\Storage\SessionStore;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceController
{
    private $entityManager;

    private $logger;

    private $sessionStore;

    private $deviceFingerprintManager;

    public function __construct(
        EntityManager $entityManager,
        LoggerInterface $logger,
        SessionStore $sessionStore,
        DeviceFingerprintManager $deviceFingerprintManager
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->sessionStore = $sessionStore;
        $this->deviceFingerprintManager = $deviceFingerprintManager;
    }

    public function fingerprintAction(Request $request): Response
    {
        $session = $this->sessionStore->getSession();
        $device = null;

        if ($session instanceof Session) {
            if ($session->getDevices()->count() > 0) {
                $device = $session->getDevices()->first();
            }
        }

        if (!$device instanceof Device) {
            $device = new Device();
            $device->setFingerprint((string) $request->getContent());
            $device->setSession($session);

            $this->deviceFingerprintManager->generateHashes($device);

            $this->entityManager->persist($device);
            $this->entityManager->flush($device);

            $this->logger->debug(\sprintf('A new device fingerprint was added with the id %d.', $device->getId()));

            return new Response('', 201);
        }

        return new Response('', 204);
    }
}
