<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'date_booking',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker'],


                ]
            )
            ->add(
                'diner',
                ChoiceType::class,
                [
                    'choices' => [
                        'Dîner' => '1',
                        'Déjeuner' => '0',
                    ],
                    'expanded' => false, // Si vous voulez des boutons radio au lieu d'une liste déroulante
                    'multiple' => false, // Changez à true si vous voulez permettre plusieurs sélections
                    'label' => 'Choisissez le repas',
                ]
            )
            ->add('peopleNumber');

        if ($options['action'] === 'edit') {
            $builder->add(
                'bookingConfirmed',
                CheckboxType::class,
                [
                    'label' => 'Confirmer la réservation',
                    'required' => false, // Change this to false
                    // Ajoutez d'autres options au besoin
                ]
            );
        }

        $builder
            ->add(
                'hour_booking',
                TimeType::class,
                [
                    'widget' => 'single_text',

                ]
            )
            ->add('name_booking')
            ->add(
                'phone_booking',
                TelType::class,
                [
                    'attr' => [
                        'pattern' => '[0-9]{10}',
                        'title' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.'
                    ],
                ]
            )
            ->add('email_booking')
            ->add('comments');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
