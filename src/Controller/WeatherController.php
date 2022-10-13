<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\CountryRepository;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    public function cityAction(string $country, string $city, CountryRepository $countryRepository, LocationRepository $locationRepository, MeasurementRepository $measurementRepository): Response
    {
        $countryObj = $countryRepository->findOneByCode($country);
        $cityObj = $locationRepository->findOneByCountryAndCity($countryObj, str_replace('-', ' ', $city));
        $measurements = $measurementRepository->findByLocation($cityObj);
        return $this->render('weather/city.html.twig', [
            'location' => $cityObj,
            'measurements' => $measurements,
        ]);
    }
}
