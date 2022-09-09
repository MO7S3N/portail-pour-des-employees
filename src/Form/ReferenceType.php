<?php

namespace App\Form;

use App\Entity\Reference;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('pays' , TextType::class)
            ->add('nomClient' , TextType::class )
            ->add('adresseClient' , TextType::class)
            ->add('contactClient' , TextType::class)
            ->add('valeurMission' , TextareaType::class)
            ->add('servicesRendus' , TextareaType::class)
            ->add('description')
            ->add('datedebut',DateType::class ,[
                "widget"=>"single_text"
            ])
            ->add('datefin',DateType::class ,[
                "widget"=>"single_text"
            ])
            ->add('utilisateur' , EntityType::class, [
                    'class' => Utilisateur::class ,
                    'required'=>false,
                    'multiple' => true ,
                    'mapped' =>false ,
                    'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->where('u.roles = :val')
                              ->setParameter('val', '[ROLE_CONSULTANTS]');
                },
                'choice_label' => 'username',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reference::class,
        ]);
    }
}
