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
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Nom'],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner votre nom',
                    ]),
                ]
            ])
            ->add('prenom', TextType::class,  [
                'attr' => ['placeholder' => 'Prénom '],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner votre prénom',
                    ]),
                ]
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'required' => false,
                'choice_label' => 'nom',
                'label' => 'Choisissez votre secteur d\'activite ',


            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'mapped' => false,
                'required' => false,
                'choice_label' => 'nom',
                'label' => 'Choisissez vos spécialités',

            ])
            ->add('codePostal', NumberType::class, [

                'required' => false,
                'constraints' => [new Length([
                    'min' => 5,
                    'max' => 5
                ])],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner votre code postale',
                    ]),
                ],
                'attr' => ['placeholder' => 'Code Postale ...'],

            ])
            ->add('numeroRue', NumberType::class, [
                'attr' => ['placeholder' => 'Numéro'],

                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner le numéro de votre rue',
                    ]),
                ]
            ])
            ->add('nomRue', TextType::class, [
                'attr' => ['placeholder' => 'Rue'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner le nom de votre rue',
                    ]),
                ],
                'required' => false,

            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Ville'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner le nom de votre ville',
                    ]),
                ],
            ])
            ->add('complementAdresse', TextType::class, ['required' => false,])
            ->add(
                'pseudo',
                TextType::class,
                [
                    'attr' => ['placeholder' => 'Pseudo.'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez rensseigner votre pseudo',
                        ]),
                    ],
                ]
            )

            ->add('genre', EntityType::class, [
                'label' => 'Genre',

                'required' => false,
                'class' => Genre::class,
                'choice_label' => 'nom',
            ])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}