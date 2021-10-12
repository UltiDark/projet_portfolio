<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
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
    private $contenu;

    /**
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="commentaires")
     */
    private $id_projet;

    /**
     * @ORM\ManyToOne(targetEntity=Galerie::class, inversedBy="commentaires")
     */
    private $id_galerie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getIdGalerie(): ?Galerie
    {
        return $this->id_galerie;
    }

    public function setIdGalerie(?Galerie $id_galerie): self
    {
        $this->id_galerie = $id_galerie;

        return $this;
    }
}
