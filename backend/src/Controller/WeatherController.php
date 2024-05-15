<?php

namespace App\Controller;

use App\Services\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class WeatherController extends AbstractController
{
    public function __construct(
        private WeatherService $weatherService
    )
    {
    }

    #[Route('/weather/{city}', name: 'app_weather', methods: ['GET'])]
    public function show(string $city): JsonResponse
    {
        return $this->json($this->weatherService->getWeatherFromCity($city));
    }
}
