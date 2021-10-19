<?php

namespace App\Form;

use App\Entity\Reseau;
use App\Entity\CategorieReseau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReseauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lien', UrlType::class)
            ->add('image', FileType::class, [
                'required' => false,
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
            ->add('id_categorie', EntityType::class,[
                'class' => CategorieReseau::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reseau::class,
        ]);
    }
}
