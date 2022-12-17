<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\Request;

class AnalysisRequest
{
    private $courseCalculate;

    public function __construct(CourseCalculate $courseCalculate)
    {
        $this->courseCalculate = $courseCalculate;
    }

    public function analysisCalculator(Request $request): array
    {
        $capital = $request->request->get('capital');
        $startY = $request->request->get('start_y');
        $startM = $request->request->get('start_m');
        $startD = $request->request->get('start_d');
        $endY = $request->request->get('end_y');
        $endM = $request->request->get('end_m');
        $endD = $request->request->get('end_d');
        $currency = $request->request->get('currency');
        $startString = "$startY-$startM-$startD";
        $startDate = new \DateTime($startString);
        $endString = "$endY-$endM-$endD";
        $endDate = new \DateTime($endString);
        $difference = date_diff($startDate, $endDate)->days;

        if (
            !$capital ||
            $startY > date('Y') ||
            $endY > date('Y') ||
            $startM > 12 || $startM < 1 ||
            $endM > 12 || $endM < 1 ||
            $startD < 1 || $startD > 31 ||
            $endD < 1 || $endD > 31 ||
            $startDate >= $endDate ||
            $difference > 365
        ){
            return [
                'failure' => 'fail',
                'from' => strtolower($currency),
            ];
        }

        return $this->courseCalculate->calculateProfit(
            $startString,
            $endString,
            $capital,
            strtolower($currency)
        );
    }
}