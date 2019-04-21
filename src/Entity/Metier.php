<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 * @ORM\Table(name="metier")
 */
class Metier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var string
     *
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     */
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $archive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employe", mappedBy="metier")
     */
    private $employe;

    public function __construct()
    {
        $this->employe = new ArrayCollection();
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

    public function getArchive(): ?string
    {
        return $this->archive;
    }

    public function setArchive(string $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * @return Collection|Employe[]
     */
    public function getEmploye(): Collection
    {
        return $this->employe;
    }

    public function addEmploye(Employe $employe): self
    {
        if (!$this->employe->contains($employe)) {
            $this->employe[] = $employe;
            $employe->setMetier($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): self
    {
        if ($this->employe->contains($employe)) {
            $this->employe->removeElement($employe);
            // set the owning side to null (unless already changed)
            if ($employe->getMetier() === $this) {
                $employe->setMetier(null);
            }
        }

        return $this;
    }
}
