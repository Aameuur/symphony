<?php

// src/Form/ColiType.php

namespace App\Form;

use App\Entity\Coli;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Reference',
            ])
            ->add('typeDeColi', ChoiceType::class, [
                'choices' => Coli::TYPES,
                'label' => 'Type de Coli',
            ])
            ->add('categories', ChoiceType::class, [
                'choices' => Coli::CATEGORIES,
                'label' => 'Categories',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coli::class,
        ]);
    }
}
