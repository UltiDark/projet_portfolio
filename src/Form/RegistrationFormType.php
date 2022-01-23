<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
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
            
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe (8 caractères min)',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Regex('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$&+,:;=?@#|<>.^*()%!]).{12,}$/')
                    ],
                    'attr' => [
                        'placeholder' => 'Au moins une majuscule, une minuscule et un caracère spécial',
                    ],
                ],
                'second_options' => ['label' => 'Confirmation du mot de passe (8 caractères min)'],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label_attr' => [
                    'class' => 'check',
                ],
                'attr' => [
                    'class' => 'inputcheck',
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
                'label' => 'Condition d\'utilisation',
            ])
            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
