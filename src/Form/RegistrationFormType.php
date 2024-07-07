<?php

namespace App\Form;

use App\Classes\PasswordComplexity;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ ne peut pas être vide.',
                    ]),
                    new Email([
                        'message' => 'L\'adresse e-mail n\'est pas valide.',
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ], 'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ], 'label' => 'Nom',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ], 'label' => 'En créant un compte, vous acceptez les conditions d\'utilisation et de vente de Ventalis',
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Veuillez entrer un mot de passe de minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new PasswordComplexity(),
                ],
                'label' => 'Mot de passe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
