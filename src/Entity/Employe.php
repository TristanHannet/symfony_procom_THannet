<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeRepository")
 * @ORM\Table(name="employe")
 */
class Employe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Metier", inversedBy="employe")
     * @ORM\JoinColumn(nullable=false, name="metier_id")
     */
    private $metier;

    /**
     * @ORM\Column(type="float")
     */
    private $cout;

    /**
     * @ORM\Column(type="date")
     */
    private $embauche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $archive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }



    public function getMetier(): ?Metier
    {
        return $this->metier;
    }

    public function setMetier(?Metier $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(float $cout): self
    {
        $this->cout = $cout;

        return $this;
    }

    public function getEmbauche(): ?\DateTimeInterface
    {
        return $this->embauche;
    }

    public function setEmbauche(?\DateTimeInterface $embauche): self
    {
        $this->embauche = $embauche;

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
}
