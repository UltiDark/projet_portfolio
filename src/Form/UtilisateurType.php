<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'required' => false,
            ])
        ->add('prenom', TextType::class, [
            'required' => false,
            ])
        ->add('pseudo', TextType::class, [
            'required' => false,
            ])
        ->add('email', EmailType::class)
        ->add('roles', ChoiceType::class, [
            'label' => 'Rôles',
            'choice_attr' => [
                'Créateur' => ['class' => 'inputcheck'],
                'Administrateur' => ['class' => 'inputcheck'],
            ],
            'multiple' => true,
            'expanded' => true,
            'required' => false,
            'choices' => [
                'Créateur' => 'ROLE_CREATEUR',
                'Administrateur' => 'ROLE_ADMIN',
            ]
        ])
        ->add('Modifier', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
