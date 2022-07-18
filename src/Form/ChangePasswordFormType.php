<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                            new NotBlank([
                                'message' => 'Veuillez rensseigner votre mot de passe',
                            ]),
                            new Length([
                                'min' => 6,
                                'minMessage' => 'Votre mot de passe doit avoir  {{ limit }} characters',
                                // max length allowed by Symfony for security reasons
                                'max' => 4096,
                            ]),
                            new Regex([
                                'pattern' => '/\d/',
                                'message' => 'Votre mot de passe doit contenir au moins un chiffre.'
                            ]),
                            new Regex([
                                'pattern' => '/[a-z]/',
                                'message' => 'Votre mot de passe doit contenir au moins une lettre minuscule.'
                            ]),
                            new Regex([
                                'pattern' => '/[A-Z]/',
                                'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule.'
                            ]),
                            new Regex([
                                'pattern' => '/[!@#$%^&*]/',
                                'message' => 'Votre mot de passe doit contenir au moins un caractère spécial.'
                            ]),
                    ],
                    'label' => 'New password',
                ],
                'second_options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    'label' => 'Repeat Password',
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
