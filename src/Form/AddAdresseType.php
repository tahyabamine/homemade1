<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Console\Completion\Suggestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('codePostal', NumberType::class, [
                'attr' => ['name' => 'cp'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rensseigner votre code postale',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                    ]),
                ]
            ])
            ->add('nomRue', TextType::class, [
                'attr' => ['name' => 'adresse']
            ])
            ->add('numeroRue', NumberType::class)
            ->add('complementAdresse',TextType::class,[
                'constraints' => [
                    new Length([
                        'max' => 150
                    ])
                    ],
                'required'=> false

            ])
            ->add('ville', TextType::class, [
                'attr' => ['name' => 'ville']
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'=> false
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
