<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre :'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu :'
            ])
            ->add('startAt', DateType::class,
                [
                  'widget' => 'choice',
                  'label' => 'Début :'
                ])
            ->add('endAt', DateType::class,
                [
                  'widget' => 'choice',
                  'label' => 'Fin :'
                ])
            //->add('author') ===> must be the user authenticated
        ;
    }
}
