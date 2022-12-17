<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function error(Request $request): Response
    {
        $from = $request->query->get('from');
        if ($from == 'home') $urlButton = '/home';
        else $urlButton = '/only_'.$from;

        return $this->render('error/error.html.twig', [
            'title' => 'Error',
            'url' => $urlButton,
        ]);
    }
}