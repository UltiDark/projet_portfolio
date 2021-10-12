<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        /*->add('id_categorie', EntityType::class,[
            'class' => Categorie::class,
            'choice_label' => 'nom'
        ])*/
        ->add('lien',FileType::class,
        [
            'label' => 'Logo (.PNG, .JPEG, .GIF, .SVG file)',
            'mapped' => false,
            'required' => false,
            'attr' => ['title' => ""],
            'constraints' => [
                new File([
                    'maxSize' => '512k',
                    'mimeTypes' => [
                        'application/png',
                        'application/x-png',
                        'application/jpg',
                        'application/x-jpg',
                    ],
                ])
            ],
        ]
        )
        ->add('nom',TextType::class)
        ->add('document',FileType::class,[
            'label' => 'Document (.PDF, .RAR, .ZIP file)',
            'required'=>false,
            'constraints' => [
                new File([
                    'maxSize' => '512k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                        'application/rar',
                        'application/x-rar',
                        'application/zip',
                        'application/x-zip',
                    ],
                ])
            ],        ])
        ->add('build',FileType::class,[
            'label' => 'Build (.RAR, .ZIP file)',
            'required'=>false,
            'constraints' => [
                new File([
                    'maxSize' => '512k',
                    'mimeTypes' => [
                        'application/rar',
                        'application/x-rar',
                        'application/zip',
                        'application/x-zip',
                    ],
                ])
            ],
        ])
        ->add('images',FileType::class,[
            'required'=>false,
            'multiple'=>true,
            'attr' => ['rows'=>'10'],
            'mapped' => false,
            'label' => 'Bibliothèque d\'image (.PNG, .JPEG, .GIF, .SVG file)',
            'constraints' => [
                new File([
                    'maxSize' => '512k',
                    'mimeTypes' => [
                        'image/png',
                        'image/x-png',
                        'image/jpg',
                        'image/x-jpg',
                        'image/jpeg',
                        'image/x-jpeg',
                        'image/gif',
                        'image/x-gif',
                        'image/svg',
                        'image/x-svg',
                    ],
                ])
            ],
        ])
        ->add('pitch',TextareaType::class,[
            'required'=>false,
            'attr' => ['rows'=>'10']
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
