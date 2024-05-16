<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private string $apiKey = '';

    public function __construct(
        private readonly CacheInterface      $cache,
        private readonly HttpClientInterface $httpClient,
        readonly ContainerBagInterface       $params
    )
    {
        $this->apiKey = $params->get('OPENWEATHER_API_KEY');
    }

    public function getWeatherFromCity(string $city)
    {
        return $this->cache->get($city, function (ItemInterface $item) use ($city) {
            $item->expiresAfter(60 * 10);

            $response = $this->httpClient->request(
                'GET',
                "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}&lang=fr&units=metric"
            );

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to fetch data from API');
            }

            return $response->toArray();
        });
    }
}