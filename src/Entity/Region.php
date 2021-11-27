<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_region", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_region", type="string", length=225, nullable=false)
     * @Groups("post:read")
     */
    private $nomRegion;

    public function getIdRegion(): ?int
    {
        return $this->idRegion;
    }

    public function getNomRegion(): ?string
    {
        return $this->nomRegion;
    }

    public function setNomRegion(string $nomRegion): self
    {
        $this->nomRegion = $nomRegion;

        return $this;
    }


}
