<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Messenger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessengerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('titre', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
        
                'constraints' => [
                    new Length([
                        'max' => 100
                    ])
                ]
            ])

            ->add('contenue', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
        
                    'constraints' => [
                        new Length([
                            'max' => 300
                        ])
                    ]
    
            ])
            ->add('envoyer', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messenger::class,
        ]);
    }
}
