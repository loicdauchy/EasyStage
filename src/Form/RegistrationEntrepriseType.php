<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('CP')
            ->add('Ville')
            ->add('tel')
            ->add('portfolio')
            ->add('avatar', ElFinderType::class, ['instance' => 'form', 'enable' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
