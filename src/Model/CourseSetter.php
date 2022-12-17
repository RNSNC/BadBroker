<?php

namespace App\Model;

use App\Entity\Course;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\ExchangeRatesApi;

class CourseSetter
{
    private $entity;

    private $api;

    public function __construct(
        ManagerRegistry $doctrine,
        ExchangeRatesApi $api
    ){
        $this->entity = $doctrine->getManager();
        $this->api = $api;
    }

    public function setCourses(array $withoutDate): void
    {
        $startDate = reset($withoutDate);

        //if one - download of one day and set in database
        if (count($withoutDate) == 1 ) {
            $course = $this->api->getCourseOne($startDate);
            $this->setCourse($course, $startDate);
            return;
        }

        //downloading data from the service
        $rates = $this->api->getCourseTimeSeries($startDate, end($withoutDate));

        //set data in database
        foreach ($withoutDate as $day)
        {
            $this->setCourse($rates[$day], $day, false);
        }
        $this->entity->flush();
    }

    public function setCourse(array $data, $day, bool $flush = true): void
    {
        $course = new Course();
        $course
            ->setDate(new \DateTime($day))
            ->setEur($data['EUR'])
            ->setRub($data['RUB'])
            ->setGbp($data['GBP'])
            ->setJpy($data['JPY'])
        ;
        $this->entity->persist($course);
        if ($flush) $this->entity->flush();
    }
}