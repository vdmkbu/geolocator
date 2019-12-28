<?php

namespace App\Geolocator;


use App\Geolocator\Interfaces\Locator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;
use Psr\SimpleCache\CacheInterface;

class CacheLocator implements Locator
{
    private $next, $cache, $prefix, $ttl;

    public function __construct(Locator $next, CacheInterface $cache, string $prefix, int $ttl)
    {
        $this->next = $next;
        $this->cache = $cache;
        $this->prefix = $prefix;
        $this->ttl = $ttl;
    }

    public function locate(Ip $ip): ?Location
    {
        $key = $this->prefix . '-' . $ip->getValue();
        $location = $this->cache->get($key);

        if ($location === null) {
            $location = $this->next->locate($ip);
            $this->cache->set($key, $location, $this->ttl);
        }

        return $location;
    }
}