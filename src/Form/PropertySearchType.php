<?php

namespace App\Form;

use App\entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'dateMin',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker'],


                ]
            )
            ->add(
                'dateMax',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker'],


                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'rechercher',

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false,

        ]);
    }
}
