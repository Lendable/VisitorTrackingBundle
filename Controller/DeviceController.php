<?php

namespace Alpha\VisitorTrackingBundle\Controller;

use Alpha\VisitorTrackingBundle\Entity\Device;
use Alpha\VisitorTrackingBundle\EventListener\VisitorTrackingSubscriber;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceController extends Controller
{
    public function fingerprintAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cookie = $request->cookies->get(VisitorTrackingSubscriber::COOKIE_SESSION, false);
        $device = null;
        $session = null;

        if ($cookie) {
            $device = $em->getRepository('AlphaVisitorTrackingBundle:Device')->findOneBySession($cookie);
            $session = $em->getRepository('AlphaVisitorTrackingBundle:Session')->find($cookie);
        }

        if (false === $device instanceof Device) {
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