<?php

namespace App\Form;

use App\Form\DomaineType;
use App\Form\CapaciteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DomaineTotalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Domaine', DomaineType::class,[
                'label' => ' ',
                'domaine' => $options['domaine']
            ])
        ;
        if(!empty($options['groupes'])){
            for ($i = 0; $i < $options['nombre']; $i++){
                $builder
                ->add('Capacite_'.$i, CapaciteType::class,[
                    'label' => ' ',
                    'domaine' => $options['domaine'],
                    'groupes' => $options['groupes'][$i],
                    'iGroupe' => $i
                ])
                ;
            }
        }
        else{
            for ($i = 0; $i < $options['nombre']; $i++){
                $builder
                ->add('Capacite_'.$i, CapaciteType::class,[
                    'label' => ' ',
                    'domaine' => $options['domaine'],
                    'iGroupe' => $i
                ])
                ;
            }
        }
        $builder
        ->add('post', HiddenType::class,[
            'attr' =>['value' => $options['nombre']],
        ])    
        ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'nombre' => 1,
            'allow_extra_fields' => true,
            'domaine' => ' ',
            'groupes' => ' ',
            'iGroupe' => 0,
        ]);
        $resolver->setAllowedTypes('nombre', 'int');
    }
}
