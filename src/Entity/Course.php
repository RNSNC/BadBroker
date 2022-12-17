<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $eur;

    /**
     * @ORM\Column(type="float")
     */
    private $rub;

    /**
     * @ORM\Column(type="float")
     */
    private $gbp;

    /**
     * @ORM\Column(type="float")
     */
    private $jpy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEur(): ?float
    {
        return $this->eur;
    }

    public function setEur($eur): self
    {
        $this->eur = $eur;

        return $this;
    }

    public function getRub(): ?float
    {
        return $this->rub;
    }

    public function setRub($rub): self
    {
        $this->rub = $rub;

        return $this;
    }

    public function getGbp(): ?float
    {
        return $this->gbp;
    }

    public function setGbp($gbp): self
    {
        $this->gbp = $gbp;

        return $this;
    }

    public function getJpy(): ?float
    {
        return $this->jpy;
    }

    public function setJpy($jpy): self
    {
        $this->jpy = $jpy;

        return $this;
    }
}