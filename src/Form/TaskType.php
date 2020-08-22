<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', TextareaType::class)
            ->add('startAt', DateType::class,
                [
                  'widget' => 'choice'
                ])
            ->add('endAt', DateType::class,
                [
                  'widget' => 'choice'
                ])
            //->add('author') ===> must be the user authenticated
        ;
    }
}
