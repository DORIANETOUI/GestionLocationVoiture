<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('immatriculation', TextType::class)
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'libelleMarque',
            ])
            ->add('modele', TextType::class)
            ->add('prix', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
