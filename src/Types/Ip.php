<?php

namespace App\Geolocator\Types;


final class Ip
{
    private $value;

    public function __construct(string $ip)
    {
        if (empty($ip)) {
            throw new \InvalidArgumentException('Empty IP.');
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new \InvalidArgumentException('Invalid IP ' . $ip);
        }

        $this->value = $ip;
    }

    public function getValue()
    {
        return $this->value;
    }
}