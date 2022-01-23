<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'attr' => array(
                    'placeholder' => 'Nom (Requis)',
                    'pattern' => '[A-Za-z]{3,}'
                )
            ])
            ->add('prenom', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Prénom (Requis)',
                    'pattern' => '[A-Za-z]{3,}'
                )
            ])
            ->add('mail', EmailType::class, [
                'attr' => array(
                    'placeholder' => 'Email (Requis)'
                )
            ])
            ->add('objet', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Objet de l\'email (Requis)'
                )
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => array(
                    'placeholder' => 'Contenu (Requis)',
                    'rows' => 5
                ),
                'label' => 'Message :'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyé',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
