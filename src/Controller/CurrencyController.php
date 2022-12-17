<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    /**
     * @Route("/only_{currency}", name="currency")
     */
    public function currency($currency): Response
    {
        return $this->render('currency/currency.html.twig',[
            'title' => ucfirst($currency),
        ]);
    }
}