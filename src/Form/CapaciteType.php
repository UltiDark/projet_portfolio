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
        if(!empty($options['groupes']) && !empty($options['domaine']['groupes'][$options['iGroupe']]['capacite'])){
            $builder
            ->add('id_groupe', EntityType::class,[
                'class' => Groupe::class,    
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'allow_extra_fields' => true,
                'data' => $options['groupes']
    
            ])
            ->add('nom', TextareaType::class,[
                'attr' => ['rows'=>'10'],
                'label' => 'Capacités',
                'allow_extra_fields' => true,
                'data' => $options['domaine']['groupes'][$options['iGroupe']]['capacite']
            ]);
        }
        else{
            $builder
            ->add('id_groupe', EntityType::class,[
                'class' => Groupe::class,    
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'allow_extra_fields' => true,
    
            ])
            ->add('nom', TextareaType::class,[
                'attr' => ['rows'=>'10'],
                'label' => 'Capacités',
                'allow_extra_fields' => true,    
            ]); 
        }


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Capacite::class,
            'allow_extra_fields' => true,
            'allow_add' => true,
            'domaine' => '',
            'iGroupe' => 0,
            'groupes'=> ''


        ]);
    }
}
