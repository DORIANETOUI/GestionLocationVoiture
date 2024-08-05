<?php

// src/Form/LocationType.php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LocationType extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeLocation', TextType::class)
            ->add('dateDebutLocation', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFinLocation', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('client', EntityType::class, [
                'class' => 'App\Entity\Client',
            ]) 
            ->add('voiture', EntityType::class, [
                'class' => 'App\Entity\Voiture',
            ])
            ->add('chauffeur', EntityType::class, [
                'class' => 'App\Entity\Chauffeur',
            ])
            ->add('prixLocation', TextType::class, [
                'disabled' => true, // Désactive le champ pour le rendre non modifiable
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
