<?php

namespace App\Form;

use App\Entity\Measurement;
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
            ->add('location')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
