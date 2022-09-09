<?php

namespace App\Controller;

use App\Entity\ExperienceAcademique;
use App\Entity\Reference;
use App\Entity\SearchReference;
use App\Entity\Utilisateur;
use App\Form\ReferenceType;
use App\Form\SearchReferenceType;
use App\Repository\DiplomesCertificatsRepository;
use App\Repository\ReferenceRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceController extends AbstractController
{
    /**
     * @Route("/reference", name="references")
     */
    public function index(ReferenceRepository $repository   , Request $request): Response
    {
        $searchreference = new SearchReference();
        $form = $this->createForm(SearchReferenceType::class , $searchreference);
        $form->handleRequest($request);
        $references = $repository->findref($searchreference);
        return $this->render('reference/index.html.twig', [
            'references' => $references,
            'form'=>$form->createView()
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
            foreach ($request->request->get('reference')['utilisateur'] as $conid)
            {
                $consultant = $this->getDoctrine()->getRepository(Utilisateur::class)->find($conid);
                $reference->addUtilisateur($consultant);
            }
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

    /**
     * @Route("/reference/dowload/{id}", name="download_reference")
     */
    public function download_pdf(Utilisateur $admin , ReferenceRepository $certificatsRepository)
    {
        $pdfoptions = new Options();
        $pdfoptions->set('defaultFont' , 'Arial');
        $pdfoptions->set('isHtml5ParserEnabled', true);
        $pdfoptions->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($pdfoptions);
        $context = stream_context_create([
            'ssl'=> [
                'verify_peer' => False ,
                'verify_peer_name' => False ,
                'allow_self_signe' => True
            ]
        ]);
        $dompdf->setHttpContext($context);
        $html = $this->renderView('reference/pdfreference.html.twig' , [
            'admin' =>$admin ,

        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4' , 'portrait');
        $dompdf->render();
        $fichier = 'reference : '.$admin->getNom().' '.$admin->getPrenom();
        $dompdf->stream($fichier ,[
            'Attachement' => true
        ]);
        return new Response();
    }





}
