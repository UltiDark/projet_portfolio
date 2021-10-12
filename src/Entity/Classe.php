<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
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
     * @ORM\OneToMany(targetEntity=Frise::class, mappedBy="id_classe")
     */
    private $frises;

    public function __construct()
    {
        $this->frises = new ArrayCollection();
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
     * @return Collection|Frise[]
     */
    public function getFrises(): Collection
    {
        return $this->frises;
    }

    public function addFrise(Frise $frise): self
    {
        if (!$this->frises->contains($frise)) {
            $this->frises[] = $frise;
            $frise->setIdClasse($this);
        }

        return $this;
    }

    public function removeFrise(Frise $frise): self
    {
        if ($this->frises->removeElement($frise)) {
            // set the owning side to null (unless already changed)
            if ($frise->getIdClasse() === $this) {
                $frise->setIdClasse(null);
            }
        }

        return $this;
    }
}
