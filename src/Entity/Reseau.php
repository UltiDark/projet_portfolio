<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReseauRepository::class)
 */
class Reseau
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
    private $lien;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reseaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieReseau::class, inversedBy="reseaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_categorie;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getIdCategorie(): ?CategorieReseau
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?CategorieReseau $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }
}
