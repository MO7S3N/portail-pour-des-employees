<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferenceRepository::class)
 */
class Reference
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datefin;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, mappedBy="reference")
     */
    private $utilisateurs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AdresseClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valeurMission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $servicesRendus;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->addReference($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeReference($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre ?: '';
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getContactClient(): ?string
    {
        return $this->contactClient;
    }

    public function setContactClient(string $contactClient): self
    {
        $this->contactClient = $contactClient;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->AdresseClient;
    }

    public function setAdresseClient(string $AdresseClient): self
    {
        $this->AdresseClient = $AdresseClient;

        return $this;
    }

    public function getValeurMission(): ?string
    {
        return $this->valeurMission;
    }

    public function setValeurMission(string $valeurMission): self
    {
        $this->valeurMission = $valeurMission;

        return $this;
    }

    public function getServicesRendus(): ?string
    {
        return $this->servicesRendus;
    }

    public function setServicesRendus(string $servicesRendus): self
    {
        $this->servicesRendus = $servicesRendus;

        return $this;
    }


}
