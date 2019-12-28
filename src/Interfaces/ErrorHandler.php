<?php

namespace App\Geolocator\Interfaces;


interface ErrorHandler
{
    public function handle(\Exception $exception): void;
}