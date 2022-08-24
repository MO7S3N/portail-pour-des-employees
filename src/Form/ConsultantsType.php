<?php

namespace App\Form;

use App\Entity\Utilisateur;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class)
            ->add('prenom', TextType::class)
            ->add('username',TextType::class)
            ->add('password',PasswordType::class)
            ->add('imageFile',FileType::class,['required'=>false])
            ->add('entreprise')
            ->add('email', EmailType::class)
            ->add('nationalite')
            ->add('grade' , ChoiceType::class , [
                'choices' =>
                    [
                        'Junior' =>'Junior' ,
                        'Senior' => 'Senior',
                        'AssistantManager' => '' ,
                        'Manager' => 'Manager' ,
                        'SeniorManager'=>'SeniorManager',
                        'Directeur'=>'Directeur',
                        'Partner'=>'Partner',
                        'Stagiaire'=>'Stagiaire',
                        'AssociéPartner'=>'AssociéPartner'
                    ]
            ])
            ->add('departement',TextType::class)
            ->add('pays',TextType::class)
            ->add('Anneeexperience',IntegerType::class )
            ->add('langueParle', ChoiceType::class , [
                'choices' =>
                    [
                        'Anglais'=>'Anglais',
                        'Français'=>'Français',
                        'Espagnol'=> 'Espagnol',
                        'Turc'=>'Turc',
                        'Arabe'=>'Arabe',
                        'Italien'=>'Italien',
                        'Allemand'=>'Allemand',
                        'Russe'=>'Russe',
                        'Portugais'=>'Portugais',
                        'Coreen'=>'Coreen',
                        'Japonnais'=>'Japonnais',
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
