<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\CountryRepository;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    private MeasurementRepository $measurementRepository;
    private CountryRepository $countryRepository;
    private LocationRepository $locationRepository;

    public function __construct(MeasurementRepository $measurementRepository, CountryRepository $countryRepository, LocationRepository $locationRepository)
    {
        $this->measurementRepository = $measurementRepository;
        $this->countryRepository = $countryRepository;
        $this->locationRepository = $locationRepository;
    }

    public function getWeatherForLocation(Location $location): array
    {
        $measurements = $this->measurementRepository->findByLocation($location);
        return $measurements;
    }

    public function getWeatherForId(int $id): array
    {
        $location = $this->locationRepository->find($id);
        $measurements = $this->measurementRepository->findByLocation($location);
        return $measurements;
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $cityName): array
    {
        $countryObj = $this->countryRepository->findOneByCode($countryCode);
        $location = $this->locationRepository->findOneByCountryAndCity($countryObj, str_replace('-', ' ', $cityName));
        $measurements = $this->getWeatherForLocation($location);
        return $measurements;
    }
}