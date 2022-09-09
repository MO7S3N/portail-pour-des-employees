<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 *     fields = {"username"},
 *     message="le username existe déjà"
 * )
 * @Vich\Uploadable()
 */
class Utilisateur implements UserInterface
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
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="integer" , length=255)
     */
    private $Anneeexperience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langueParle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="image_admin", fileNameProperty="image")
     */
    private $imageFile;

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile)
        {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=ExperienceAcademique::class, mappedBy="utilisateur")
     */
    private $experienceacademiques;

    /**
     * @ORM\OneToMany(targetEntity=ExperienceProfessionnel::class, mappedBy="utilisateur")
     */
    private $experiencesProfessionel;

    /**
     * @ORM\Column(type="integer" , options={"default" : 0})
     */
    private $enabled;

    /**
     * @ORM\ManyToMany(targetEntity=Reference::class, inversedBy="utilisateurs")
     */
    private $reference;

    /**
     * @ORM\OneToMany(targetEntity=DiplomesCertificats::class, mappedBy="utilisateur" ,
     * orphanRemoval = true , cascade = { "persist"})
     */
    private $diplomes;



    public function __construct()
    {
        $this->experienceacademiques = new ArrayCollection();
        $this->experiencesProfessionel = new ArrayCollection();
        $this->reference = new ArrayCollection();
        $this->diplomes = new ArrayCollection();

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

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

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
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

    public function getAnneeexperience()
    {
        return $this->Anneeexperience;
    }

    public function setAnneeexperience(int $Anneeexperience): self
    {
        $this->Anneeexperience = $Anneeexperience;

        return $this;
    }

    public function getLangueParle(): ?string
    {
        return $this->langueParle;
    }

    public function setLangueParle(string $langueParle): self
    {
        $this->langueParle = $langueParle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return [$this->roles];
    }

    public function setRoles(?string $roles) :self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection<int, ExperienceAcademique>
     */
    public function getExperienceacademiques(): Collection
    {
        return $this->experienceacademiques;
    }

    public function addExperienceacademique(ExperienceAcademique $experienceacademique): self
    {
        if (!$this->experienceacademiques->contains($experienceacademique)) {
            $this->experienceacademiques[] = $experienceacademique;
            $experienceacademique->setUtilisateur($this);
        }

        return $this;
    }

    public function removeExperienceacademique(ExperienceAcademique $experienceacademique): self
    {
        if ($this->experienceacademiques->removeElement($experienceacademique)) {
            // set the owning side to null (unless already changed)
            if ($experienceacademique->getUtilisateur() === $this) {
                $experienceacademique->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExperienceProfessionnel>
     */
    public function getExperiencesProfessionel(): Collection
    {
        return $this->experiencesProfessionel;
    }

    public function addExperiencesProfessionel(ExperienceProfessionnel $experiencesProfessionel): self
    {
        if (!$this->experiencesProfessionel->contains($experiencesProfessionel)) {
            $this->experiencesProfessionel[] = $experiencesProfessionel;
            $experiencesProfessionel->setUtilisateur($this);
        }

        return $this;
    }

    public function removeExperiencesProfessionel(ExperienceProfessionnel $experiencesProfessionel): self
    {
        if ($this->experiencesProfessionel->removeElement($experiencesProfessionel)) {
            // set the owning side to null (unless already changed)
            if ($experiencesProfessionel->getUtilisateur() === $this) {
                $experiencesProfessionel->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getEnabled(): ?int
    {
        return $this->enabled;
    }

    public function setEnabled(int $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection<int, Reference>
     */
    public function getReference(): Collection
    {
        return $this->reference;
    }

    public function addReference(Reference $reference): self
    {
        if (!$this->reference->contains($reference)) {
            $this->reference[] = $reference;
        }

        return $this;
    }

    public function removeReference(Reference $reference): self
    {
        $this->reference->removeElement($reference);

        return $this;
    }

    public function __toString(): string
    {
        return $this->username ?: '';
    }

    /**
     * @return Collection<int, DiplomesCertificats>
     */
    public function getDiplomes(): Collection
    {
        return $this->diplomes;
    }

    public function addDiplome(DiplomesCertificats $diplome): self
    {
        if (!$this->diplomes->contains($diplome)) {
            $this->diplomes[] = $diplome;
            $diplome->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDiplome(DiplomesCertificats $diplome): self
    {
        if ($this->diplomes->removeElement($diplome)) {
            // set the owning side to null (unless already changed)
            if ($diplome->getUtilisateur() === $this) {
                $diplome->setUtilisateur(null);
            }
        }

        return $this;
    }


}
