<?php

namespace App\Controller;

use App\Entity\ExperienceAcademique;
use App\Entity\ExperienceProfessionnel;
use App\Entity\Utilisateur;
use App\Form\ExpacademiqueType;
use App\Form\ExpproffesionelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceController extends AbstractController
{
    /**
     * @Route("/expacademique/ajouter/{id}", name="ajouter_expacademique")
     * @Route("/expacademique/modifier/{id}", name="modifier_expacademique")
     */
    public function Ajouter_exp_academique(ExperienceAcademique $expaca = null , Request $request , Utilisateur $consultant)
    {   $modif = false;
        if(!$expaca)
        {
            $expaca = new ExperienceAcademique();
            $modif = true;
        }
        $form=$this->createForm(ExpacademiqueType::class,$expaca);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $expaca->setUtilisateur($consultant);
            $em->persist($expaca);
            $em->flush();
            if($consultant->getRoles()[0] == '[ROLE_CONSULTANTS]')
            {
                return $this->redirectToRoute('view_profile_consultant' , [ 'id' => $consultant->getId()]);
            }
            return $this->redirectToRoute('consultants');
        }
        return $this->render('experience/new_exp_academique.html.twig', [
            "form"=> $form->createView() ,
            "modif" => $modif
        ]);
    }

    /**
     * @Route("/expprofessionel/ajouter/{id}", name="ajouter_expprofessionel")
     * @Route("/expprofessionel/modifier/{id}", name="modifier_expprofessionel")
     */
    public function Ajouter_exp_profeesionel(ExperienceProfessionnel $exppro = null , Request $request , Utilisateur $consultant)
    {
        $modif = false;
        if(!$exppro)
        {
            $exppro = new ExperienceProfessionnel();
            $modif = true;
        }
        $form=$this->createForm(ExpproffesionelType::class,$exppro);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $exppro->setUtilisateur($consultant);
            $em->persist($exppro);
            $em->flush();
            if($consultant->getRoles()[0] == '[ROLE_CONSULTANTS]')
            {
                return $this->redirectToRoute('view_profile_consultant' , [ 'id' => $consultant->getId()]);
            }
            return $this->redirectToRoute('consultants');
        }
        return $this->render('experience/new_exp_professionel.html.twig', [
            "form"=> $form->createView() ,
            "modif" => $modif
        ]);
    }
}
