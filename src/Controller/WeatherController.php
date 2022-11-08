<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\CountryRepository;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use App\Service\WeatherUtil;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    public function cityAction(string $country, string $city, WeatherUtil $weatherUtil): Response
    {
        $measurements = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'country' => strtoupper($country),
            'measurements' => $measurements,
        ]);
    }
}
