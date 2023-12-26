<?php

namespace App\Form;

use App\Entity\stock;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_product', TextType::class, [
                'attr' => [
                    'class' => 'form-control', //bootswatch
                    'minlenght' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom du produit',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(
                        min: 2,
                        max: 50,
                        minMessage: 'Your first name must be at least {{ limit }} characters long',
                        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
                    ),
                    new Assert\NotBlank(),
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control', //bootswatch
                ],
                'label' => 'Description du produit',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])

            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control', //bootswatch
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\NotBlank(),
                ]
            ])
            // ->add('stock', IntegerType::class, [
            //     'attr' => [
            //         'class' => 'form-control', //bootswatch
            //         'minlenght' => '2',
            //         'maxlength' => '50'
            //     ],
            //     'label' => 'Quantité produit',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            //     'constraints' => [
            //         new Assert\Positive(),
            //         new Assert\NotBlank(),
            //     ]
            // ])
            ->add('active_product', ChoiceType::class, [
                'choices'  => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'attr' => [
                    'class' => 'form-control', //bootswatch
                ],
                'label' => 'Produit actif',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])

            // ->add('quantityPrepared', ChoiceType::class)
            // , [
            //     'choices'  => [
            //         'Oui' => 1,
            //         'Non' => 0,
            //     ],
            //     'attr' => [
            //         'class' => 'form-control', //bootswatch
            //     ],
            //     'label' => 'Produit actif',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            //     'constraints' => [
            //         new Assert\NotBlank(),
            //     ]
            // ])
            // ->add('categories', ChoiceType::class, [
            //     'attr' => [
            //         'class' => 'form-control', //bootswatch
            //         'minlenght' => '2',
            //         'maxlength' => '50'
            //     ],
            //     'label' => 'Catégorie produit',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4'
            //     ],
            // ])

            // ->add('categories', ChoiceType::class, [
            //     'choices' => $yourArrayOfCategories, // Remplacez par votre tableau d'entités Category
            //     'choice_label' => 'name_category', // Remplacez par le champ que vous souhaitez afficher
            //     'multiple' => false,
            //     'expanded' => true,
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            //     'label' => 'Catégories du produit',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4',
            //     ],
            // ])

            // ->add('image')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Sauvegarder'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
