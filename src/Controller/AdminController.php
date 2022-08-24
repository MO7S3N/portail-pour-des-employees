<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\AdminType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function Inscription(Request $request, UserPasswordEncoderInterface $encoder , MailerInterface $mailer): Response
    {
        $admin = new Utilisateur();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordcrypt = $encoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($passwordcrypt);
            $admin->setEntreprise("");
            $admin->setNationalite("");
            $admin->setGrade("");
            $admin->setDepartement("");
            $admin->setPays("");
            $admin->setAnneeexperience(0);
            $admin->setLangueParle("");
            $admin->setRoles('[ROLE_ADMIN]');
            $admin->setEnabled(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            $email  = (new  TemplatedEmail())
                       ->from('test@Ey.com')
                       ->to($admin->getEmail())
                       ->subject('verification compte')
                       ->htmlTemplate('emails/toadmin.html.twig')
                       ->context([
                           'admin'=>$admin
                       ]);
            $mailer->send($email);
            $this->addFlash('message','le message a ete bien envoye');
            return $this->redirectToRoute('login');
        }
        return $this->render('admin/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admins", name="admins")
     */
    public function index(UtilisateurRepository $repository): Response
    {
        $admins = $repository->findadmins();
        return $this->render('admin/indexBack.html.twig', [
            'admins' => $admins
        ]);
    }

    /**
     * @Route("/confirmer_compte/{id}", name="confirmer_compte")
     */
    public function confirmer_compte(Utilisateur $admin): Response
    {
        $em = $this->getDoctrine()->getManager();
        $admin->setEnabled(1);
        $em->persist($admin);
        $em->flush();
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/admins/ajouter", name="ajouter_admins")
     */
    public function Ajouter_admins(Utilisateur $admin = null , Request $request ,  UserPasswordEncoderInterface $encoder)
    {   $modif = false;
        if(!$admin)
        {
            $admin = new Utilisateur();
            $modif = true;
        }
        $form=$this->createForm(AdminType::class,$admin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordcrypt = $encoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($passwordcrypt);
            $admin->setEntreprise("");
            $admin->setEmail("");
            $admin->setNationalite("");
            $admin->setGrade("");
            $admin->setDepartement("");
            $admin->setPays("");
            $admin->setAnneeexperience(0);
            $admin->setLangueParle("");
            $admin->setRoles('[ROLE_ADMIN]');
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            return $this->redirectToRoute('admins');
        }
        return $this->render('admin/new_admin.html.twig', [
            "form"=> $form->createView() ,
            "modif" => $modif
        ]);
    }

    /**
     * @Route("/admin/supprimer/{id}", name="supprimer_admins")
     */
    public function delete(Utilisateur $admin)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($admin);
        $em->flush();
        $this->addFlash('success',"L'action a ete effectué");
        return $this->redirectToRoute('admins');
    }


}
