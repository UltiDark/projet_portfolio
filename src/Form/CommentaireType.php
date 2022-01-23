<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', HiddenType::class, [
            ])
            ->add('email', EmailType::class, [
                'attr' => array(
                    'placeholder' => 'Email (Requis)',
                    'style' => 'width : 100%'
                )
            ])
            ->add('commentaire', TextareaType::class, [
                'attr' => array(
                    'placeholder' => 'Commentaire (Requis)',
                    'rows' => 5
                ),
                'label' => 'Message :'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyé',
                'attr' => array(
                    'class' => 'modalGalerie',
                    'style' => 'z-index : 999'

                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
