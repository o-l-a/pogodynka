<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/weather/api', name: 'app_weather_api')]
    public function index(Request $request, WeatherUtil $weatherUtil): Response
    {
        $payload = $request->getContent();
        $payload = json_decode($payload, true);
        $country = $payload['country'];
        $city = $payload['city'];
        $format = $payload['format'];
        $measurements = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        $measurements_array = [];
        foreach ($measurements as $measurement) {
            $measurement_entry = [];
            $measurement_entry['date'] = $measurement->getDate()->format('Y-m-d');
            $measurement_entry['description'] = $measurement->getDescription()->getDescription();
            $measurement_entry['temperature'] = $measurement->getTemperature();
            $measurement_entry['feelsLike'] = $measurement->getFeelsLike();
            $measurement_entry['tempMin'] = $measurement->getTempMin();
            $measurement_entry['tempMax'] = $measurement->getTempMax();
            $measurement_entry['pressure'] = $measurement->getPressure();
            $measurement_entry['precipitation'] = $measurement->getPrecipitation();
            $measurement_entry['rain'] = $measurement->getRain();
            $measurement_entry['snow'] = $measurement->getSnow();
            $measurement_entry['clouds'] = $measurement->getClouds();
            $measurement_entry['humidity'] = $measurement->getHumidity();
            $measurement_entry['windSpeed'] = $measurement->getWindSpeed();
            $measurement_entry['windGustSpeed'] = $measurement->getWindGustSpeed();
            $measurement_entry['windDirection'] = $measurement->getWindDirection();
            $measurements_array[] = $measurement_entry;
        }
        $response = new Response();
        if ($format == 'json') {
            $response->setContent(json_encode([
                'country' => $country,
                'city' => $city,
                'weather' => $measurements_array,
            ]));
            $response->headers->set('Content-Type', 'application/json');
        } elseif ($format == 'csv') {
            $csv = [];
//            $csv[] = implode(',');
            foreach ($measurements_array as $item) {
                $csv[] = implode(',', ([$country, $city] + $item));
            }
            $response->setContent(implode("\n", $csv));
            $response->headers->set('Content-Type', 'text/csv');
        }
        return $response;
    }
}
