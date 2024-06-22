<?php

// src/Form/PlanningType.php

namespace App\Form;
use App\Entity\User;
use App\Entity\UserType;
use App\Entity\Planning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $wilayas = [
            'Tunis' => '1000',
            'Sfax' => '3000',
            'Sousse' => '4000',
            'Ettadhamen' => '2061',
            'Kairouan' => '3100',
            'Gabes' => '6000',
            'Bizerte' => '7000',
            'Ariana' => '2037',
            'Gafsa' => '2100',
            'La Goulette' => '2060',
            'Monastir' => '5000',
            'Medenine' => '4100',
            'Ben Arous' => '2013',
            'Kasserine' => '1200',
            'Nabeul' => '8000',
            'Beja' => '9000',
            'Mahdia' => '5100',
            'Kelibia' => '8090',
            'Jendouba' => '8100',
            'Zarzis' => '4170',
            'Hammamet' => '8050',
            'El Kef' => '7100',
            'Kebili' => '4200',
            'Siliana' => '6100'
        ];

        $builder
            ->add('deliveryDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datetimepicker'],
            ])
            ->add('deliveryAddress', ChoiceType::class, [
                'choices' => $wilayas,
                'placeholder' => 'Choose a wilaya',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('postalCode', TextType::class, [
                'required' => false,
                'disabled' => true, // Postal code should be disabled to allow JavaScript to update it
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
                // Ensure that the agent field is not disabled or read-only to allow editing
                'disabled' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
