<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity
 */
class District
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_district", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idDistrict;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_district", type="string", length=225, nullable=false)
     * @Groups("post:read")
     */
    private $nomDistrict;

    /**
     * @var int
     *
     * @ORM\Column(name="region", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $region;

    public function getIdDistrict(): ?int
    {
        return $this->idDistrict;
    }

    public function getNomDistrict(): ?string
    {
        return $this->nomDistrict;
    }

    public function setNomDistrict(string $nomDistrict): self
    {
        $this->nomDistrict = $nomDistrict;

        return $this;
    }
    public function getRegion(): ?int
    {
        return $this->region;
    }

    public function setRegion(int $region): self
    {
        $this->region = $region;

        return $this;
    }


}
