<?php

// src/Form/NotificationType.php
namespace App\Form;

use App\Entity\Notification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType if needed

class NotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('message', TextType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username', // Adjust according to your User entity
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Info' => 'info',
                    'Warning' => 'warning',
                    'Error' => 'error',
                ],
            ])
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    'Low' => 'low',
                    'Medium' => 'medium',
                    'High' => 'high',
                ],
            ])
            ->add('isRead', CheckboxType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notification::class,
        ]);
    }
}
