<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Image as img;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('contenue', TextareaType::class)
            ->add('prix', NumberType::class, [
                'required' => false,
                'label' =>  'Prix',
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ])
            ->add('images', FileType::class, [
                'required' => false,
                'label' =>  'Les images',
                'multiple' => true,
                'mapped' => false,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '5M',
                        ]),
                        new Image
                    ]),
                ]
            ])
            ->add('showNumber', CheckboxType::class, [
                'required' => false,
                'label' =>  'Afficher mon numero de telephone',
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
