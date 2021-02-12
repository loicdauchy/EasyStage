<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Promotion;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditeUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ])
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('CP')
            ->add('Ville')
            ->add('tel')
            ->add('portfolio')
            ->add('github')
            ->add('pseudoGithub')
            ->add('CV')
            ->add('promo', EntityType::class, [
                'class' => Promotion::class,
                  'choice_label' => 'nom',
                  'label' => 'Séléctionnez votre promotion'
            ])
            ->add('avatar', ElFinderType::class, ['instance' => 'form', 'enable' => true])
            ->add('mobile', ChoiceType::class, [
                'choices' => [
                    'Non' => 0,
                    'Oui' => 1
                ]
            ])
            ->add('situation', ChoiceType::class, [
                'choices' => [
                    'Aucun entretient ou stage trouvé' => 0,
                    'Entretient prévu' => 1,
                    'Stage trouvé' => 2
                ]
            ])
            ->add('mobileZone', ChoiceType::class, [
                'choices' => [
                    'Toute la France' => 0,
                    'Régions' => 1,
                    'Départements' => 2
                ]
            ])
            ->add('competences', EntityType::class, [
                'class' => Competence::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
                'label' => 'Sélectionné vos compétences'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}