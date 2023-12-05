<?php

namespace App\Entity;

use DateTimeInterface;

class PropertySearch
{
    private $dateMin;

    private $dateMax;

    public function getDateMin(): ?DateTimeInterface
    {
        return $this->dateMin;
    }

    public function setDateMin(DateTimeInterface $dateMin): PropertySearch
    {
        $this->dateMin = $dateMin;

        return $this;
    }

    public function getDateMax(): ?DateTimeInterface
    {
        return $this->dateMax;
    }

    public function setDateMax(DateTimeInterface $dateMax): PropertySearch
    {
        $this->dateMax = $dateMax;

        return $this;
    }
}
