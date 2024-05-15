<?php

namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class FrontEndUrlGeneratorService
{
    private $baseUrl;

    public function __construct(ContainerBagInterface $params)
    {
        $this->baseUrl = $params->get('frontend_url');
    }

    public function generate(string $path): string
    {
        $path = ltrim($path, '/');
        return $this->baseUrl . $path;
    }
}