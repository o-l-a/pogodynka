<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location-id',
    description: 'Get weather forecast for the location specified by id.',
)]
class WeatherLocationIdCommand extends Command
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Id of the location.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');
        $measurements = $this->weatherUtil->getWeatherForId($id);
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
        $output->writeln(json_encode([
            'id' => $id,
            'weather' => $measurements_array,
        ]));
        return Command::SUCCESS;
    }
}
