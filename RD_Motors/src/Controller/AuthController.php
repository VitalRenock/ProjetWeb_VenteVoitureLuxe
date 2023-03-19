<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'auth.login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('auth/index.html.twig', [
            'error'=>$authenticationUtils->getLastAuthenticationError(),
        ]);
    }
    #[Route('/logout',name: 'auth.logout')]
    public function logout()
    {
        //Automatic
    }
}
