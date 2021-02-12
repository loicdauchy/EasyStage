<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requestDate', DateTimeType::class, ['widget' => 'single_text', 'input' => 'datetime'])
            ->add('relanceDate', DateTimeType::class,['required'=>false, 'empty_data' => '', 'widget' => 'single_text', 'input' => 'datetime'])
            ->add('meetingDate', DateTimeType::class,['required'=>false, 'empty_data' => '', 'widget' => 'single_text', 'input' => 'datetime'])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En attente' => 0,
                    'Relancée' => 1,
                    'Positive' => 2,
                    'Négative' => 3
                ]
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
