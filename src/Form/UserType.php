<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use App\Form\FormExtension\RepeatedPasswordType;

class UserType extends AbstractType
{
    /**
     * buildForm
     *
     * @param  FormBuilderInterface $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => "Nom d'utilisateur (*)",
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Le nom d\'utilisateur'
                    ]
                ]
            )
            ->add('password', RepeatedPasswordType::class)
            // ->add(
            //     'password',
            //     RepeatedType::class,
            //     [
            //         'type' => PasswordType::class,
            //         'invalid_message' => 'Les deux mots de passe doivent correspondre.',
            //         'required' => true,
            //         'first_options'  => ['label' => 'Mot de passe'],
            //         'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
            //         'attr' => [
            //             'class' => 'form-control'
            //         ]
            //     ]
            // )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Adresse email (*)',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'L\'adresse email'
                    ]
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                // RadioType::class,
                [
                    'choices' => [
                        'Admininistrateur' => 'ROLE_ADMIN',
                        'Utilisateur' => 'ROLE_USER',
                    ],
                    'label' => 'Roles (*)',
                    'expanded'  => false, // liste déroulante
                    'multiple'  => true, // choix multiple
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            );
    }
}
