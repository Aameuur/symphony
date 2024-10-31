<?php

namespace App\Form;

use App\Entity\Planning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Destination; 
use App\Entity\Coli;
use Symfony\Component\Form\Extension\Core\Type\TextType; 

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $destinations = $options['destinations']; // Fetch dynamic destinations
        $colis = $options['colis']; // Fetch dynamic colis

        $builder
            ->add('deliveryDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datetimepicker'],
            ])
            ->add('departAddress', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'name', // Adjust based on your Destination entity properties
                'placeholder' => 'Select a depart address',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('deliveryAddress', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'name', // Adjust based on your Destination entity properties
                'placeholder' => 'Select a delivery address',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('reference', EntityType::class, [
                'class' => Coli::class,
                'choice_label' => 'reference', // Adjust based on your Coli entity properties
                'placeholder' => 'Select a reference',
            ])
            ->add('agent', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstName', // Adjust based on User entity properties
                'placeholder' => 'Select an agent',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ]);
            /* ->add('departLongitude', TextType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('departLatitude', TextType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('deliveryLongitude', TextType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('deliveryLatitude', TextType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control'],
            ]); */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['destinations', 'colis']); // Set the required options
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
