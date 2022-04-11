<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\User;
use App\Entity\Region;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Nom ...'],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name',
                    ]),
                ]
            ])
            ->add('prenom', TextType::class,  [
                'attr' => ['placeholder' => 'Prénom ...'],
                'label' => false
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'required' => false,
                'choice_label' => 'nom',
                'attr' => ['placeholder' => 'Choisissez votre région ...'],
                'label' => false
            ])
            ->add('specialite', EntityType::class, [

                'class' => Specialite::class,
                'mapped' => false,
                'required' => false,
                'choice_label' => 'nom',
                'attr' => ['placeholder' => 'Choisissez vos spécialités ...'],
                'label' => false

            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Email ...'],
                'label' => false,
                'constraints' => [new Email]
            ])
            ->add('codePostal', NumberType::class, [
                'constraints' => [new Length([
                    'min' => 5,
                    'max' => 5
                ])],
                'attr' => ['placeholder' => 'Email ...'],
                'label' => false,
            ])
            ->add('numeroRue', NumberType::class)
            ->add('nomRue', TextType::class)
            ->add('complementAdresse', TextType::class, ['required' => false,])
            ->add(
                'pseudo',
                TextType::class
            )
            ->add('avatar', FileType::class, [
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                    ]),
                    new Image
                ]
            ])
            ->add('genre', EntityType::class, [
                'required' => false,
                'class' => Genre::class,
                'choice_label' => 'nom',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['type' => 'password'],
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
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
        ]);
    }
}