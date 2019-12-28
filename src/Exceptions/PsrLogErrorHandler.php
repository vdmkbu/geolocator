<?php

namespace App\Geolocator\Exceptions;


use Psr\Log\LoggerInterface;

class PsrLogErrorHandler
{
    private $logger;

    public function __construct(LoggerInterface $logger)
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