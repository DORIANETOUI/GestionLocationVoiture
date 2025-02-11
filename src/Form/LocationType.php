<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Ajoute cette ligne
use App\Entity\Client;
use App\Entity\Voiture;
use App\Entity\Chauffeur;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeLocation', TextType::class)
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'nomClient', 
            ])
            ->add('voiture', EntityType::class, [
                'class' => Voiture::class,
                'choice_label' => 'immatriculation', 
            ])
            ->add('chauffeur', EntityType::class, [
                'class' => Chauffeur::class,
                'choice_label' => 'nomChauffeur',
                'required' => false, // Chauffeur facultatif
            ])
            ->add('dateDebutLocation', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFinLocation', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('destination', ChoiceType::class, [
                'choices' => [
                    'Abidjan' => 'Abidjan',
                    'Hors Abidjan' => 'Hors Abidjan',
                ],
                'placeholder' => 'Choisissez la destination',
            ])
            
            ->add('prixLocation', NumberType::class, [
                'mapped' => false, // Ce champ ne sera pas mappé à l'entité
                'attr' => ['readonly' => true], // Champ en lecture seule
            ])
            
            ->add('rendu', CheckboxType::class, [
                'label' => 'Véhicule rendu',
                'required' => false, // Ce champ peut être facultatif
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}

