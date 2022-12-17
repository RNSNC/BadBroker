<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/home.html.twig',[
            'title' => 'Home',
        ]);
    }

    /**
     * @Route("/")
     */
    public function redirectToHome(): Response
    {
        return $this->redirectToRoute('home');
    }
}