<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
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
     * @ORM\OneToMany(targetEntity=Capacite::class, mappedBy="id_groupe")
     */
    private $capacites;

    public function __construct()
    {
        $this->capacites = new ArrayCollection();
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

    /**
     * @return Collection|Capacite[]
     */
    public function getCapacites(): Collection
    {
        return $this->capacites;
    }

    public function addCapacite(Capacite $capacite): self
    {
        if (!$this->capacites->contains($capacite)) {
            $this->capacites[] = $capacite;
            $capacite->setIdGroupe($this);
        }

        return $this;
    }

    public function removeCapacite(Capacite $capacite): self
    {
        if ($this->capacites->removeElement($capacite)) {
            // set the owning side to null (unless already changed)
            if ($capacite->getIdGroupe() === $this) {
                $capacite->setIdGroupe(null);
            }
        }

        return $this;
    }
}
