<?php

namespace App\Form\FormExtension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RepeatedPasswordType extends AbstractType
{
    /**
     * getParent
     *
     * @return string
     */
    public function getParent(): string
    {
        return RepeatedType::class;
    }

    /**
     * configureOptions
     *
     * @param  OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $constraints = [
            new NotBlank(
                [
                    'message' => 'Entrer le mot de passe.',
                ]
            ),
            new Length(
                [
                    'min' => 6,
                    'minMessage' => 'Le mot de passe doit contenir au moins 6 caractères',
                    'max' => 10,
                    'maxMessage' => 'Le mot de passe doit contenir au plus 10 caractères.',
                ]
            ),
        ];

        $resolver->setDefaults(
            [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe saisis ne correspondent pas.',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe (*) :',
                    'label_attr' => [
                        'title' => 'Le mot de passe doit avoir entre 6 et 10 caractères.'
                    ],
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control',
                        'placeholder' => 'Le mot de passe'
                    ],
                    'constraints' => $constraints,
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe (*) :',
                    'label_attr' => [
                        'title' => 'Confirmez le mot de passe.'
                    ],
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control',
                        'placeholder' => 'Répéter le mot de passe'
                    ],
                    'constraints' => $constraints,
                ]
            ]
        );
    }
}
