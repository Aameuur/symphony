<?php

// src/Form/PlanningType.php

namespace App\Form;

use App\Entity\Planning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locations = $options['locations'];

        $builder
            ->add('deliveryDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datetimepicker'],
            ])
            ->add('departAddress', ChoiceType::class, [
                'choices' => array_flip($locations),
                'placeholder' => 'Select a depart address',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('deliveryAddress', ChoiceType::class, [
                'choices' => array_flip($locations),
                'placeholder' => 'Select a delivery address',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('reference', ChoiceType::class, [ 
                'choices' => [
                    'Ref001' => 'Ref001',
                    'Ref002' => 'Ref002',
                    'Ref003' => 'Ref003',
                    'Ref004' => 'Ref004',
                    'Ref005' => 'Ref005',
                ],
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
            ])
            ->add('departLongitude', TextType::class, [
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('locations');
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
