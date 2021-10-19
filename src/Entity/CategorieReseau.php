<?php

namespace App\Entity;

use App\Repository\CategorieReseauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieReseauRepository::class)
 */
class CategorieReseau
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
     * @ORM\Column(type="text")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Reseau::class, mappedBy="id_categorie")
     */
    private $reseaux;

    public function __construct()
    {
        $this->reseaux = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Reseau[]
     */
    public function getReseaux(): Collection
    {
        return $this->reseaux;
    }

    public function addReseaux(Reseau $reseaux): self
    {
        if (!$this->reseaux->contains($reseaux)) {
            $this->reseaux[] = $reseaux;
            $reseaux->setIdCategorie($this);
        }

        return $this;
    }

    public function removeReseaux(Reseau $reseaux): self
    {
        if ($this->reseaux->removeElement($reseaux)) {
            // set the owning side to null (unless already changed)
            if ($reseaux->getIdCategorie() === $this) {
                $reseaux->setIdCategorie(null);
            }
        }

        return $this;
    }
}
