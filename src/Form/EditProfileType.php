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
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner votre nom',
                    ]),
                ]
            ])
            ->add('prenom', TextType::class,  [
                'attr' => ['placeholder' => 'Prénom '],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner votre prénom',
                    ]),
                ]
            ])
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
                'attr' => array(
                    'class' => 'form-control'
                )
            ])
            ->add('numTel', TelType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false
            ])
            ->add('Modifier', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}