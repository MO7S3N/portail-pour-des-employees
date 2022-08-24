<?php

namespace App\Form;

use App\Entity\ExperienceProfessionnel;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpproffesionelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datedebut',DateType::class ,[
                "widget"=>"single_text"
            ])
            ->add('datefin',DateType::class ,[
                "widget"=>"single_text"
            ])
            ->add('nomentreprise',TextType::class)
            ->add('intituleduposte',TextType::class)
            ->add('lieu',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExperienceProfessionnel::class,
        ]);
    }
}
