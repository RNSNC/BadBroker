<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\AnalysisRequest;

class CalculatorController extends AbstractController
{
    /**
     * @Route("/calculator", name="calculator")
     */
    public function calculator(Request $request, AnalysisRequest $analysis): Response
    {
        $profit = $analysis->analysisCalculator($request);

        if (isset($profit['failure'])){
            return $this->redirectToRoute('error',[
                'from' => $profit['from'],
            ]);
        }
        return $this->render('calculator/calculator.html.twig',[
            'title' => 'Calculator',
            'profit' => $profit,
        ]);
    }
}