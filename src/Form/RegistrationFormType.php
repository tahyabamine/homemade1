<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Region;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom',
                    ]),

                ],
                'attr' => ['class' => 'req']
            ])
            ->add('region', EntityType::class, [
                'label' => 'Région',
                'class' => Region::class,
                'choice_label' => 'nom',
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ])
            ->add('prenom', TextType::class,  [
                'label' => 'Prénom',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom',
                    ]),
                ]
            ])

            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [new Email],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre Email',
                    ]),
                ]
            ])

            ->add('pseudo',TextType::class,[
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez rensseigner votre pseudo',
                        ]),
                    ],
                ]
            )
            ->add('avatar', FileType::class, [
                'required' => false,
                'label' =>  'Photo de profile',
                'data_class' => null,


                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                    ]),
                    new Image
                ]
            ])
            ->add('genre', EntityType::class, [
                'label' => 'Genre',
                'required' => false,
                'class' => Genre::class,
                'choice_label' => 'nom',
                'attr' => array(
                    'class' => 'form-control'
                )
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,

                'required' => true,
                'label' => 'Mot de passe',
                'attr' => ['type' => 'password'],
                'attr' => ['placeholder' => 'Mot de passe'],

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
            ])
            ->add('numTel', TelType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Conditions d\'utilisation',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_update' => false
        ]);
        $resolver->setAllowedTypes('is_update', 'bool');
    }
}
