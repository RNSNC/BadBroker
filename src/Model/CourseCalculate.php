<?php

namespace App\Model;

use App\Repository\CourseRepository;

class CourseCalculate
{
    private $repository;

    private $setter;

    public function __construct(CourseRepository $repository, CourseSetter $setter)
    {
        $this->repository = $repository;
        $this->setter = $setter;
    }

    public function calculateProfit($startDate, $endDate, $capital, $currency): array
    {
        //checking every day in database
        $withoutDate = array();
        for ($date = new \DateTime($startDate); $date <= new \DateTime($endDate); $date->modify('+1day'))
        {
            if (!$this->repository->findOneBy(['date' => $date])){
                $withoutDate[] = $date->format('Y-m-d');
            }
        }

        //upload if needed
        if ($withoutDate) $this->setter->setCourses($withoutDate);

        //get all data from database
        $courses = $this->repository->findIntervalDate($startDate, $endDate);

        //calculate the best course
        return $this->calculateBestCourse($courses, $capital, $currency);
    }

    private function calculateBestCourse($courses, int $capital, $currency): array
    {
        //start-up capital
        $maxBenefit = [
            'money' => $capital,
            'capital' => $capital,
        ];

        //all or only one currency
        if ($currency == 'home'){
            $currencies = [
                'eur' => '',
                'rub' => '',
                'gbp' => '',
                'jpy' => '',
            ];
            $maxBenefit['from'] = "/".$currency; //return button, in case of failure
        }else{
            $currencies = [$currency => ''];
            $maxBenefit['from'] = "/only_".$currency;
        }

        foreach ($courses as $keyCourse => $course)
        {
            if ($course->getDate() == end($courses)->getDate()) continue;

            //currencies in 1st day
            if (isset($currencies['eur'])) $currencies['eur'] = $course->getEur()*$capital;
            if (isset($currencies['rub'])) $currencies['rub'] = $course->getRub()*$capital;
            if (isset($currencies['gbp'])) $currencies['gbp'] = $course->getGbp()*$capital;
            if (isset($currencies['jpy'])) $currencies['jpy'] = $course->getJpy()*$capital;

            //find best course
            for (
                ($date = clone $course->getDate())->modify('+1day');
                $date <= end($courses)->getDate();
                $date->modify('+1day')
            ){
                //all next days by key from the current day
                static $d = 0;
                $d++;

                //get
                foreach ($currencies as $keyCurrency => $currency)
                {
                    switch ($keyCurrency) {
                        case "eur" :
                            $courseBroker = $currency/$courses[$keyCourse+$d]->getEur()-$d;
                            break;
                        case "rub" :
                            $courseBroker = $currency/$courses[$keyCourse+$d]->getRub()-$d;
                            break;
                        case "gbp" :
                            $courseBroker = $currency/$courses[$keyCourse+$d]->getGbp()-$d;
                            break;
                        case "jpy" :
                            $courseBroker = $currency/$courses[$keyCourse+$d]->getJpy()-$d;
                            break;
                    }

                    //if found better
                    if ($maxBenefit['money'] < $courseBroker)
                    {
                        $maxBenefit['money'] = $courseBroker;
                        $maxBenefit['start'] = $course->getDate()->format('Y-m-d');
                        $maxBenefit['end'] = $date->format('Y-m-d');
                        $maxBenefit['currency'] = strtoupper($keyCurrency);
                        $maxBenefit['profit'] = round($courseBroker-$capital, 2);
                    }
                }
            }
            $d = 0;
        }
        return $maxBenefit;
    }
}