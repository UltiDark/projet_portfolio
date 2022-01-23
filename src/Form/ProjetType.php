<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Projet;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
        ->add('nom',TextType::class)
        ->add('date',DateType::class, [
            'widget' => 'single_text',
            'input_format' => 'd/M/Y'
        ])
        ->add('lien',TextType::class, [
            'label' => 'Lien de la vidéo',
            'mapped' => false,
            'required' => false,
        ]
        )
        ->add('logo',FileType::class,[
            'attr' => ['rows'=>'10'],
            'mapped' => false,
            'label' => 'Logo (.PNG, .JPEG, .GIF, .SVG file)',
            'constraints' => [
                new File([
                    'maxSize' => '512k',
                    'mimeTypes' => [
                        'image/*',
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
        ])
        ->add('document',FileType::class,[
            'label' => 'Document (.PDF, .RAR, .ZIP file)',
            'required'=>false,
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '100M',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/rar',
                        'application/zip',
                        'application/x-pdf',
                        'application/x-rar',
                        'application/x-zip',
                    ],
                ])
            ],        ])
        ->add('build',FileType::class,[
            'label' => 'Build (.RAR, .ZIP file)',
            'required'=>false,
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '100M',
                    'mimeTypes' => [
                        'application/rar',
                        'application/zip',
                        'application/x-rar',
                        'application/x-zip',
                    ],
                ])
            ],
        ])

        ->add('camera',TextType::class)
        ->add('characters',TextType::class)
        ->add('controllers',TextType::class)
        ->add('pitch',TextareaType::class,[
            'required'=>false,
            'attr' => ['rows'=>'10']
        ])
        ->add('gameplay',TextareaType::class,[
            'required'=>false,
            'attr' => ['rows'=>'10']
        ])
        ->add('visuel',TextareaType::class,[
            'required'=>false,
            'attr' => ['rows'=>'10']
        ])
        ->add('id_utilisateur',EntityType::class,[
            'class' => Utilisateur::class,
            'choice_label' => 'email',
            'label' => 'Membres du projet',
            'multiple' => true,
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
