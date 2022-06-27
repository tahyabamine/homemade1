<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Console\Completion\Suggestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('codePostal',NumberType::class, [               
                'constraints' => [new Length([
                    'min' => 5,
                    'max' => 5
                ])],
            ]

            )
            ->add('nomRue')
            ->add('numeroRue')
            ->add('complementAdresse')
            ->add('ville')
            ->add('submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
