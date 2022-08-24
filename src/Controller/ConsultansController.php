<?php

namespace App\Controller;

use App\Entity\ExperienceAcademique;
use App\Entity\ExperienceProfessionnel;
use App\Entity\Reference;
use App\Entity\Search;
use App\Entity\Utilisateur;
use App\Form\AdminType;
use App\Form\AssignReferenceType;
use App\Form\ConsultantsType;
use App\Form\SearchType;
use App\Repository\ExperienceAcademiqueRepository;
use App\Repository\ExperienceProfessionnelRepository;
use App\Repository\ReferenceRepository;
use App\Repository\UtilisateurRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ConsultansController extends AbstractController
{
    /**
     * @Route("/consultants", name="consultants")
     */
    public function index(UtilisateurRepository $repository , Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class , $search);
        $form->handleRequest($request);
        $consultants = $repository->findconsultants($search);
        return $this->render('consultants/index.html.twig', [
            "consultants" => $consultants ,
            "form" =>$form->createView()
        ]);
    }

    /**
     * @Route("/assignreference/{id}", name="assignreference")
     */
    public function Assignreference(Request $request , Utilisateur $consultant): Response
    {

        $form = $this->createForm(AssignReferenceType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($request->request->get('assign_reference')['reference'] as $refid)
            {
                $reference = $this->getDoctrine()->getRepository(Reference::class)->find($refid);
                $consultant->addReference($reference);
                $em = $this->getDoctrine()->getManager();
                $em->persist($consultant);
                $em->flush();
            }
            if($this->getUser()->getRoles()[0] == '[ROLE_CONSULTANTS]')
            {
                return $this->redirectToRoute('view_profile_consultant' , [ 'id' => $this->getUser()->getId()]);
            }
            else if($this->getUser()->getRoles()[0] == '[ROLE_ADMIN]')
            {
                return $this->redirectToRoute('consultants');
            }

        }
        return $this->render('consultants/assign_reference.html.twig', [
            "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/consultans/ajouter", name="ajouter_consultans")
     * @Route("/consultans/modifier/{id}", name="modifier_consultans")
     */
    public function Ajouter_consultants(Utilisateur $admin = null , Request $request ,  UserPasswordEncoderInterface $encoder , MailerInterface $mailer)
    {   $modif = false;
        if(!$admin)
        {
            $admin = new Utilisateur();
            $modif = true;
        }
        $form=$this->createForm(ConsultantsType::class,$admin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pass_non_crypt = $admin->getPassword();
            $passwordcrypt = $encoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($passwordcrypt);
            $admin->setRoles('[ROLE_CONSULTANTS]');
            $admin->setEnabled(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            $email  = (new  TemplatedEmail())
                ->from('test@Ey.com')
                ->to($admin->getEmail())
                ->subject('Informations Personnelles')
                ->htmlTemplate('emails/toconsultant.html.twig')
                ->context([
                    'admin'=>$admin,
                    'pwd'=>$pass_non_crypt
                ]);
            $mailer->send($email);
            if($this->getUser()->getRoles()[0] == '[ROLE_CONSULTANTS]')
            {
                return $this->redirectToRoute('view_profile_consultant' , [ 'id' => $this->getUser()->getId()]);
            }
            else if($this->getUser()->getRoles()[0] == '[ROLE_ADMIN]')
            {
                return $this->redirectToRoute('consultants');
            }
        }
        return $this->render('consultants/new_consultans.html.twig', [
            "form"=> $form->createView() ,
            "modif" => $modif
        ]);
    }

    /**
     * @Route("/consultans/view_profile/{id}", name="view_profile")
     */
    public function view_profile(Utilisateur $admin , ExperienceProfessionnelRepository $expro , ExperienceAcademiqueRepository $experienceAcademique , UtilisateurRepository $repository)
    {
        $expro = $expro->findBy(['utilisateur'=> $admin]);
        $expac = $experienceAcademique->findBy(['utilisateur'=> $admin]);
        $countref = $repository->countreferences($admin);
        return $this->render('consultants/view_profile.html.twig', [
            "admin"=> $admin ,
            "expro" =>$expro ,
            "expac" =>$expac ,
            "countref" => $countref

        ]);
    }

    /**
     * @Route("/consultans/view_profile_consultant/{id}", name="view_profile_consultant")
     */
    public function _consultant(Utilisateur $admin , ExperienceProfessionnelRepository $expro , ExperienceAcademiqueRepository $experienceAcademique , UtilisateurRepository $repository)
    {
        $expro = $expro->findBy(['utilisateur'=> $admin]);
        $expac = $experienceAcademique->findBy(['utilisateur'=> $admin]);
        $countref = $repository->countreferences($admin);
        return $this->render('consultants/view_profile_consultant.html.twig', [
            "admin"=> $admin ,
            "expro" =>$expro ,
            "expac" =>$expac ,
            "countref" => $countref

        ]);
    }

    /**
     * @Route("/consultans/supprimer/{id}", name="supprimer_consultans")
     */
    public function delete(Utilisateur $admin)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($admin);
        $em->flush();
        $this->addFlash('success',"L'action a ete effectué");
        return $this->redirectToRoute('consultants');
    }

    /**
     * @Route("/consultans/dowload/{id}", name="download_consultants")
     */
    public function download_pdf(Utilisateur $admin ,  ExperienceProfessionnelRepository $expro , ExperienceAcademiqueRepository $experienceAcademique)
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
        $expro = $expro->findBy(['utilisateur'=> $admin]);
        $expac = $experienceAcademique->findBy(['utilisateur'=> $admin]);
        $html = $this->renderView('consultants/pdf.html.twig' , [
            'admin' =>$admin ,
            "expro" =>$expro ,
            "expac" =>$expac ,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4' , 'portrait');
        $dompdf->render();
        $fichier = 'pdf : '.$admin->getNom().' '.$admin->getPrenom();
        $dompdf->stream($fichier ,[
            'Attachement' => true
        ]);
        return new Response();
    }


    /**
     * @Route("/consulatnt/searchconsultantajax ", name="ajaxconsultant")
     */
    public function searchOffreajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $requestString=$request->get('searchValue');
        $consultants = $repository->findUtilisateurbyname($requestString);
        return $this->render('consultants/consultantsajax.html.twig', [
            "consultants"=>$consultants
        ]);
    }


}
