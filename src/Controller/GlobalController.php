<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GlobalController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('global/index.html.twig', [

        ]);
    }


    /**
     * @Route("/", name="login")
     *
     */

    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('admin/login.html.twig',[
            'LastUserName' => $utils->getLastUsername() ,
            'error' => $utils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */

    public function logout()
    {

    }
}
