<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Data i czas pomiaru
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])


            // Temperatura w °C
            ->add('celsius', NumberType::class, [
                'label' => 'Temperature (°C)',
                'scale' => 1,
                'attr' => [
                    'placeholder' => 'Enter temperature',
                    'class' => 'form-control',
                ],
            ])

            // Relacja do Location (wybór miasta)
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city', // wyświetla nazwę miasta zamiast ID
                'label' => 'Location',
                'placeholder' => 'Select a location',
                'attr' => [
                    'class' => 'form-select',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
