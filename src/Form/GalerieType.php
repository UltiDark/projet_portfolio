<?php

namespace App\Form;

use App\Entity\Galerie;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;


class GalerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_categorie', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'nom'
            ])
            ->add('lien',FileType::class,[
                'data_class' => null,
                'label' => 'Image (.PNG, .JPEG, .GIF, .SVG file)',
                'constraints' => [
                    new File([
                        'maxSize' => '512k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                    ])
                ],
            ])
            ->add('nom',TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Galerie::class,
        ]);
    }
}
