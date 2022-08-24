<?php

namespace App\Controller;

use App\Entity\ExperienceAcademique;
use App\Entity\Reference;
use App\Form\ReferenceType;
use App\Repository\ReferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceController extends AbstractController
{
    /**
     * @Route("/reference", name="references")
     */
    public function index(ReferenceRepository $repository): Response
    {
        $references = $repository->findAll();
        return $this->render('reference/index.html.twig', [
            'references' => $references,
        ]);
    }

    /**
     * @Route("/reference/ajouter", name="ajouter_reference")
     * @Route("/reference/modifier/{id}", name="modifier_reference")
     */
    public function Ajouter_consultants(Reference $reference = null , Request $request)
    {   $modif = false;
        if(!$reference)
        {
            $reference = new Reference();
            $modif = true;
        }
        $form=$this->createForm(ReferenceType::class,$reference);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reference);
            $em->flush();
            return $this->redirectToRoute('references');
        }
        return $this->render('reference/add_reference.html.twig', [
            "form"=> $form->createView() ,
            "modif" => $modif
        ]);
    }

    /**
     * @Route("/consultans_references/{id}", name="consultans_references")
     */
    public function consultants_references(Reference $reference)
    {
        return $this->render('reference/consultans_references.html.twig', [
           "reference" => $reference
        ]);
    }




}
