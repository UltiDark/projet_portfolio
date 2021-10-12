<?php

namespace App\Entity;

use App\Repository\FriseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriseRepository::class)
 */
class Frise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_div;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="frises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_classe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getIdDiv(): ?string
    {
        return $this->id_div;
    }

    public function setIdDiv(string $id_div): self
    {
        $this->id_div = $id_div;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdClasse(): ?Classe
    {
        return $this->id_classe;
    }

    public function setIdClasse(?Classe $id_classe): self
    {
        $this->id_classe = $id_classe;

        return $this;
    }
}
