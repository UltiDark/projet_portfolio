<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Groupe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!empty($options['domaine']['nom'])){
            $builder
            ->add('nom', TextType::class,[
                'allow_extra_fields' => true,
                'attr' =>['value' => $options['domaine']['nom']]
            ]);
        }
        else{
            $builder
            ->add('nom', TextType::class,[
                'allow_extra_fields' => true,
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Domaine::class,
            'allow_extra_fields' => true,
            'allow_add' => true,
            'domaine' => ""
        ]);
    }
}
