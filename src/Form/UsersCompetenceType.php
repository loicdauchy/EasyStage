<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersCompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('competences', EntityType::class, [
            'class' => Competence::class,
            'choice_label' => 'nom',
            'expanded' => true,
            'multiple' => true,
            'label' => 'Sélectionné vos compétences'
        ]);
    }    
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
