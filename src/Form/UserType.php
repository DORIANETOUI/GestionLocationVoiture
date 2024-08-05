<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('roles', TextType::class, [
                'label' => 'Rôles',
                //'help' => 'Séparez les rôles par des virgules',
                'mapped' => false,
                'data' => implode(', ', $options['data']->getRoles()), // Convert array to string
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function preSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (isset($data['roles'])) {
            $data['roles'] = array_map('trim', explode(',', $data['roles']));
        }

        $event->setData($data);
    }
}

