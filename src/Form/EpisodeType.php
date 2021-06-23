<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title',TextType::class)
        ->add('number',IntegerType::class)
        ->add('summary',TextareaType::class)
        ->add('season', EntityType::class, [
            'class' => Season::class,
            'choice_label' => 'programNumber',
            'multiple' => false,
            'expanded' => false,
        ]);
            
            
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
