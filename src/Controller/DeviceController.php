<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Controller;

use Alpha\VisitorTrackingBundle\Entity\Device;
use Alpha\VisitorTrackingBundle\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceController extends Controller
{
    public function fingerprintAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->get('alpha.visitor_tracking.storage.session')->getSession();
        $device = null;

        if ($session instanceof Session) {
            if ($session->getDevices()->count() > 0) {
                $device = $session->getDevices()->first();
            }
        }

        if (!$device instanceof Device) {
            $device = new Device();
            $device->setFingerprint($request->getContent());
            $device->setSession($session);

            $this->get('alpha.visitor_tracking.manager.device_fingerprint')->generateHashes($device);

            $em->persist($device);
            $em->flush($device);

            $this->get('logger')->debug(sprintf('A new device fingerprint was added with the id %d.', $device->getId()));

            return new Response('', 201);
        }

        return new Response('', 204);
    }
}
