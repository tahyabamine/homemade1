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
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('codePostal',TextType::class,[
                'attr' => ['name' => 'cp'],
            ])
            ->add('nomRue',TextType::class, [
                'attr' => ['name' => 'adresse']
            ])
            ->add('numeroRue')
            ->add('complementAdresse')
            ->add('ville', TextType::class, [
                'attr' => ['name' => 'ville']])
            ->add('submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
