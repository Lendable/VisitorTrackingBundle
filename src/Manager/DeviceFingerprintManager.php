<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\Manager;

use Alpha\VisitorTrackingBundle\Entity\Device;

class DeviceFingerprintManager
{
    private const HASHES = [
        'canvas',
        'fonts',
        'navigator',
        'plugins',
        'screen',
        'systemColors',
        'storedIds',
    ];

    public function generateHashes(Device $device): Device
    {
        $data = \json_decode($device->getFingerprint(), true);

        if (\is_array($data) && \JSON_ERROR_NONE === \json_last_error()) {
            foreach (self::HASHES as $field) {
                $method = 'set'.\ucfirst($field);
                $value = \array_key_exists($field, $data) ? \md5(\serialize($data[$field])) : null;
                $device->$method($value);
            }
        }

        return $device;
    }
}
