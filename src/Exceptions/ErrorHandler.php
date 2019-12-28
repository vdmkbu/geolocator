<?php

namespace App\Geolocator\Exceptions;


use App\Geolocator\Log\Logger;

class ErrorHandler
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(\Exception $exception): void
    {
        $this->logger->error($exception->getMessage(), [
            'exception' => $exception
        ]);
    }
}