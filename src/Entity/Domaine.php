<?php

namespace App\Entity;

use App\Repository\DomaineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DomaineRepository::class)
 */
class Domaine
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
     * @ORM\ManyToMany(targetEntity=Capacite::class, inversedBy="domaines")
     */
    private $id_capacite;

    public function __construct()
    {
        $this->id_capacite = new ArrayCollection();
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
    public function getIdCapacite(): Collection
    {
        return $this->id_capacite;
    }

    public function addIdCapacite(Capacite $idCapacite): self
    {
        if (!$this->id_capacite->contains($idCapacite)) {
            $this->id_capacite[] = $idCapacite;
        }

        return $this;
    }

    public function removeIdCapacite(Capacite $idCapacite): self
    {
        $this->id_capacite->removeElement($idCapacite);

        return $this;
    }
}
