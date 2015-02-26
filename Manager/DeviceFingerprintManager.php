<?php

namespace Alpha\VisitorTrackingBundle\Manager;

use Alpha\VisitorTrackingBundle\Entity\Device;
use Symfony\Component\HttpFoundation\Request;

class DeviceFingerprintManager
{
    private $hashes = ['canvas', 'fonts', 'navigator', 'plugins', 'screen', 'systemColors', 'storedIds'];

    public function generateHashes(Device $device)
    {
        $data = json_decode($device->getFingerprint(), true);

        if (JSON_ERROR_NONE === json_last_error() && false === empty($data)) {
            foreach ($this->hashes as $field) {
                $method = 'set' . ucfirst($field);
                $value = array_key_exists($field, $data) ? md5(serialize($data[$field])) : null;
                $device->$method($value);
            }
        }

        return $device;
    }
}
