<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Galerie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_categorie', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'nom'
            ])
            ->add('lien',TextType::class)
            ->add('nom',TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Galerie::class,
        ]);
    }
}
