<?php

// src/Form/VoitureType.php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType; // Assurez-vous que c'est bien NumberType
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('immatriculation', TextType::class)
            ->add('modele', TextType::class)
            ->add('prixAbidjan', NumberType::class)
            ->add('prixHorsAbidjan', NumberType::class)
            ->add('marque', EntityType::class, [
                'class' => 'App\Entity\Marque',
                'choice_label' => 'libelleMarque',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}

