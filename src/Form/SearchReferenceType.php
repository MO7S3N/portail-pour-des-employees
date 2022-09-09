<?php

namespace App\Form;

use App\Entity\Reference;
use App\Entity\SearchReference;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referncepays'  , EntityType::class , [
                'required'=>false,
                'label'=>'recherche par pays',
                'class'=>Reference::class,
                'choice_label'=>'pays' ,
            ])
            ->add('refernceclient', EntityType::class , [
                'required'=>false,
                'label'=>'recherche par client',
                'class'=>Reference::class,
                'choice_label'=>'nomClient' ,
            ])
            ->add('referencetitre', EntityType::class , [
                'required'=>false,
                'label'=>'recherche par titre',
                'class'=>Reference::class,
                'choice_label'=>'titre' ,
            ])
            ->add('referencedatedebut',DateType::class ,[
                "widget"=>"single_text",
                'label'=>'date debut',
                'required'=>false


            ])
            ->add('referencedatefin',DateType::class ,[
                "widget"=>"single_text",
                'label'=>'date fin',
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchReference::class,
            'method'=>'get' ,
            'csrf_protection' => false
        ]);
    }
}
