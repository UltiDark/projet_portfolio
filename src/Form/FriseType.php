<?php

namespace App\Form;

use App\Entity\Frise;
use App\Entity\Classe;
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



class FriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class, [
                'widget' => 'single_text',
                'input_format' => 'd/M/Y'
            ])
            ->add('nom',TextType::class)
            ->add('id_classe',EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie'
            ])
            ->add('id_div',TextType::class,[
                'label' => 'Div'
            ])

            ->add('lien',FileType::class,[
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
            ->add('contenu',TextareaType::class,[
                'required' => false,
                'attr' => ['rows'=>'10']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Frise::class,
        ]);
    }
}
