<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


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
        ->add('lien', UrlType::class, [
            'required' => false,
            ])
        ->add('photo',FileType::class,[
            'attr' => ['rows'=>'10'],
            'required' => false,
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
        ;
        foreach ($options['roles'] as $role){
            if($role == 'ROLE_ADMIN')
            {
                $builder
                
                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => [
                        'label' => 'Nouveau mot de passe',
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Veuillez entrer un mot de passe',
                            ]),
                            new Regex('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$&+,:;=?@#|<>.^*()%!]).{12,}$/')
                        ],
                    ],
                    'second_options' => ['label' => 'Confirmation du mot de passe'],
                    'mapped' => false,
                    'attr' => ['autocomplete' => 'new-password'],
                    
                ])
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
                    ]);
            }
        }

        
        

        $builder
        ->add('Modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'roles' => [0 => 'ROLE_USER'],
        ]);
    }
}
