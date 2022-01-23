<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
    private $lien;

    /**
     * @ORM\Column(type="text")
     */
    private $pitch;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $build;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="projets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_categorie;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="id_projet")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $camera;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $characters;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $controllers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gameplay;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $visuel;

    /**
     * @ORM\OneToMany(targetEntity=BanqueImage::class, mappedBy="id_projet", orphanRemoval=true)
     */
    private $banqueImages;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="projets")
     */
    private $id_utilisateur;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->banqueImages = new ArrayCollection();
        $this->id_utilisateur = new ArrayCollection();
    }

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

    public function getPitch(): ?string
    {
        return $this->pitch;
    }

    public function setPitch(string $pitch): self
    {
        $this->pitch = $pitch;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getBuild(): ?string
    {
        return $this->build;
    }

    public function setBuild(?string $build): self
    {
        $this->build = $build;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setIdProjet($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdProjet() === $this) {
                $commentaire->setIdProjet(null);
            }
        }

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

    public function getCamera(): ?string
    {
        return $this->camera;
    }

    public function setCamera(?string $camera): self
    {
        $this->camera = $camera;

        return $this;
    }

    public function getCharacters(): ?string
    {
        return $this->characters;
    }

    public function setCharacters(?string $characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function getControllers(): ?string
    {
        return $this->controllers;
    }

    public function setControllers(?string $controllers): self
    {
        $this->controllers = $controllers;

        return $this;
    }

    public function getGameplay(): ?string
    {
        return $this->gameplay;
    }

    public function setGameplay(string $gameplay): self
    {
        $this->gameplay = $gameplay;

        return $this;
    }

    public function getVisuel(): ?string
    {
        return $this->visuel;
    }

    public function setVisuel(string $visuel): self
    {
        $this->visuel = $visuel;

        return $this;
    }

    /**
     * @return Collection|BanqueImage[]
     */
    public function getBanqueImages(): Collection
    {
        return $this->banqueImages;
    }

    public function addBanqueImage(BanqueImage $banqueImage): self
    {
        if (!$this->banqueImages->contains($banqueImage)) {
            $this->banqueImages[] = $banqueImage;
            $banqueImage->setIdProjet($this);
        }

        return $this;
    }

    public function removeBanqueImage(BanqueImage $banqueImage): self
    {
        if ($this->banqueImages->removeElement($banqueImage)) {
            // set the owning side to null (unless already changed)
            if ($banqueImage->getIdProjet() === $this) {
                $banqueImage->setIdProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->id_utilisateur;
    }

    public function addIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if (!$this->id_utilisateur->contains($idUtilisateur)) {
            $this->id_utilisateur[] = $idUtilisateur;
        }

        return $this;
    }

    public function removeIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        $this->id_utilisateur->removeElement($idUtilisateur);

        return $this;
    }
}
