<?php

namespace App\Entity;

use App\Repository\IntroRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntroRepository::class)
 */
class Intro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $paragraphe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParagraphe(): ?string
    {
        return $this->paragraphe;
    }

    public function setParagraphe(string $paragraphe): self
    {
        $this->paragraphe = $paragraphe;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }
}
