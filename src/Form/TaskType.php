<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TaskType extends AbstractType
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
                'title',
                TextType::class,
                [
                    'label' => "Titre de votre tâche (*)",
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => "Description de votre tâche (*)",
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            //->add('author') ===> must be the user authenticated
        ;
    }
}
