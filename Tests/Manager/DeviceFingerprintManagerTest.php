<?php

namespace Alpha\VisitorTrackingBundle\Tests\Manager;

use Alpha\VisitorTrackingBundle\Entity\Device;
use Alpha\VisitorTrackingBundle\Manager\DeviceFingerprintManager;

class DeviceFingerprintManagerTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function noHashesAreGeneratedIfFingerprintIsEmpty()
    {
        $device = new Device();
        $device->setFingerprint('');

        $manager = new DeviceFingerprintManager();
        $manager->generateHashes($device);

        $this->assertNull($device->getCanvas());
        $this->assertNull($device->getFonts());
        $this->assertNull($device->getNavigator());
        $this->assertNull($device->getPlugins());
        $this->assertNull($device->getScreen());
        $this->assertNull($device->getStoredIds());
        $this->assertNull($device->getSystemColors());
    }

    /** @test */
    public function noHashesAreGeneratedIfJsonIsInvalid()
    {
        $device = new Device();
        $device->setFingerprint('{"aaa" "invalid');

        $manager = new DeviceFingerprintManager();
        $manager->generateHashes($device);

        $this->assertNull($device->getCanvas());
        $this->assertNull($device->getFonts());
        $this->assertNull($device->getNavigator());
        $this->assertNull($device->getPlugins());
        $this->assertNull($device->getScreen());
        $this->assertNull($device->getStoredIds());
        $this->assertNull($device->getSystemColors());
    }

    /** @test */
    public function noHashesAreGeneratedIfKeysDoNotExist()
    {
        $device = new Device();
        $device->setFingerprint('{"aaa": "valid", "bbb": [3, 4]}');

        $manager = new DeviceFingerprintManager();
        $manager->generateHashes($device);

        $this->assertNull($device->getCanvas());
        $this->assertNull($device->getFonts());
        $this->assertNull($device->getNavigator());
        $this->assertNull($device->getPlugins());
        $this->assertNull($device->getScreen());
        $this->assertNull($device->getStoredIds());
        $this->assertNull($device->getSystemColors());
    }

    /** @test */
    public function hashesAreGeneratedForExistingKeys()
    {
        $device = new Device();
        $device->setFingerprint('{"canvas": "valid", "screen": [3, 4]}');

        $manager = new DeviceFingerprintManager();
        $manager->generateHashes($device);

        $this->assertSame(md5(serialize("valid")), $device->getCanvas());
        $this->assertSame(md5(serialize([3, 4])), $device->getScreen());
        $this->assertNull($device->getFonts());
        $this->assertNull($device->getNavigator());
        $this->assertNull($device->getPlugins());
        $this->assertNull($device->getStoredIds());
        $this->assertNull($device->getSystemColors());
    }
}