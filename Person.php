<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Person
{

    private $birthYear;


    private $deathYear;

    // ...

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function setBirthYear(int $birthYear): self
    {
        $this->birthYear = $birthYear;

        return $this;
    }

    public function getDeathYear(): ?int
    {
        return $this->deathYear;
    }

    public function setDeathYear(?int $deathYear): self
    {
        $this->deathYear = $deathYear;

        return $this;
    }
}
