<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Offre
 *
 * @ORM\Table(name="offre")
 *
 * @ORM\Entity
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="NumOffre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $numoffre;

    /**
     * @var \DateTime
     * @ORM\Column(name="Date_creation", type="date", nullable=false)
     * @Assert\EqualTo("today")
     * @Groups("post:read")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     * @ORM\Column(name="Date_expiration", type="date", nullable=false)
     * @Assert\GreaterThan("today")
     * @Groups("post:read")
     */
    private $dateExpiration;

    /**
     * @var int
     *@Assert\Positive(message="Entrez un nombre correct")
     * @ORM\Column(name="Disponibilite", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $disponibilite;

    /**
     * @var string
     * @ORM\Column(name="Nomoffre", type="string", nullable=false)
     * @Groups("post:read")
     */
    private $nomoffre;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=225, nullable=false)
     * @Groups("post:read")
     */
    private $sexe;

    /**
     * @var int
     * @Assert\Positive(message="Entrez un nombre correct")
     * @ORM\Column(name="experience", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $experience;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau_etude", type="string", length=225, nullable=false)
     * @Groups("post:read")
     */
    private $niveauEtude;

    /**
     * @var int
     *@Assert\Positive(message="Entrez un nombre correct")
     * @ORM\Column(name="ageMin", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $agemin;

    /**
     * @var int
     *@Assert\Positive(message="Entrez un nombre correct")
     * @ORM\Column(name="ageMax", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $agemax;


    /**
     * @var string
     * @ORM\Column(name="secteur", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $secteur;


    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Groups("post:read")
     */
    private $description;

    /**
     * @var int
     * @ORM\Column(name="district", type="integer", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $district;


    public function getNumoffre(): ?int
    {
        return $this->numoffre;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getDisponibilite(): ?int
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(int $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getNomoffre(): ?string
    {
        return $this->nomoffre;
    }

    public function setNomoffre(string $nomoffre): self
    {
        $this->nomoffre = $nomoffre;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): self
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAgemin(): ?int
    {
        return $this->agemin;
    }

    public function setAgemin(int $agemin): self
    {
        $this->agemin = $agemin;

        return $this;
    }

    public function getAgemax(): ?int
    {
        return $this->agemax;
    }

    public function setAgemax(int $agemax): self
    {
        $this->agemax = $agemax;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;
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
    public function getDistrict(): ?int
    {
        return $this->district;
    }
    public function setDistrict(int $district): self
    {
        $this->district = $district;

        return $this;
    }
}
