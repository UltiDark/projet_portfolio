<?php

namespace App\Entity;

use App\Repository\BanqueImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BanqueImageRepository::class)
 */
class BanqueImage
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
     * @ORM\Column(type="string", length=255)
     */
    private $lien;

    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="banqueImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_projet;

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

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->id_projet;
    }

    public function setIdProjet(?Projet $id_projet): self
    {
        $this->id_projet = $id_projet;

        return $this;
    }
}
