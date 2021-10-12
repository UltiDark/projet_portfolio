<?php

namespace App\Form;

use App\Entity\Capacite;
use App\Entity\Groupe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapaciteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id_groupe', EntityType::class,[
            'class' => Groupe::class,    
            'choice_label' => 'nom',
            'label' => 'Catégorie',
        ])
        ->add('nom', TextareaType::class,[
            'attr' => ['rows'=>'10'],
            'label' => 'Capacités',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Capacite::class,
        ]);
    }
}
