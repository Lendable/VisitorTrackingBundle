<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Tests\Manager;

use Alpha\VisitorTrackingBundle\Entity\Device;
use Alpha\VisitorTrackingBundle\Manager\DeviceFingerprintManager;
use PHPUnit\Framework\TestCase;

class DeviceFingerprintManagerTest extends TestCase
{
    public function badFingerprintData(): iterable
    {
        yield 'empty' => [''];
        yield 'invalid json' => ['{"aaa" "invalid'];
        yield 'only non-existing keys provided' => ['{"aaa": "valid", "bbb": [3, 4]}'];
    }

    /**
     * @test
     * @dataProvider badFingerprintData
     */
    public function noHashesAreGeneratedIfFingerprintDataIsBad(string $fingerprintData): void
    {
        $device = new Device();
        $device->setFingerprint($fingerprintData);

        $manager = new DeviceFingerprintManager();
        $manager->generateHashes($device);

        $this->assertEmpty($device->getCanvas());
        $this->assertEmpty($device->getFonts());
        $this->assertEmpty($device->getNavigator());
        $this->assertEmpty($device->getPlugins());
        $this->assertEmpty($device->getScreen());
        $this->assertEmpty($device->getStoredIds());
        $this->assertEmpty($device->getSystemColors());
    }

    /**
     * @test
     */
    public function hashesAreGeneratedForExistingKeys(): void
    {
        $device = new Device();
        $device->setFingerprint('{"canvas": "valid", "screen": [3, 4]}');

        $manager = new DeviceFingerprintManager();
        $manager->generateHashes($device);

        $this->assertSame(\md5(\serialize('valid')), $device->getCanvas());
        $this->assertSame(\md5(\serialize([3, 4])), $device->getScreen());
        $this->assertEmpty($device->getFonts());
        $this->assertEmpty($device->getNavigator());
        $this->assertEmpty($device->getPlugins());
        $this->assertEmpty($device->getStoredIds());
        $this->assertEmpty($device->getSystemColors());
    }
}
