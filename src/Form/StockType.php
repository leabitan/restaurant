<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantityPrepared', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control', // bootswatch
                ],
                'label' => 'Quantité préparée',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\PositiveOrZero(),
                    new Assert\NotBlank(),
                ]
            ])
            // ->add('quantityReal', IntegerType::class, [
            //     'attr' => [
            //         'class' => 'form-control', // bootswatch
            //     ],
            //     'label' => 'Quantité réelle',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            //     'constraints' => [
            //         new Assert\PositiveOrZero(),
            //         new Assert\NotBlank(),
            //     ]
            // ])
            ->add('quantitySold', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control', // bootswatch
                ],
                'label' => 'Quantité vendue',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\PositiveOrZero(),
                    new Assert\NotBlank(),
                ]
            ]);
        // ->add('submit', SubmitType::class, [
        //     'attr' => [
        //         'class' => 'btn btn-primary mt-4'
        //     ],
        //     'label' => 'Sauvegarder'
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
