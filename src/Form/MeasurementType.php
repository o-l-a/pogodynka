<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Entity\WeatherDescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('temperature')
            ->add('feelsLike')
            ->add('tempMin')
            ->add('tempMax')
            ->add('pressure')
            ->add('precipitation')
            ->add('rain')
            ->add('snow')
            ->add('clouds')
            ->add('humidity')
            ->add('windSpeed')
            ->add('windGustSpeed')
            ->add('windDirection')
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
            ])
            ->add('description', EntityType::class, [
                'class' => WeatherDescription::class,
                'choice_label' => 'description',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
