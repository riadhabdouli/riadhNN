<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="reponseId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reponseid;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="questionId", type="integer", nullable=false)
     */
    private $questionid;

    public function getReponseid(): ?int
    {
        return $this->reponseid;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getQuestionid(): ?int
    {
        return $this->questionid;
    }

    public function setQuestionid(int $questionid): self
    {
        $this->questionid = $questionid;

        return $this;
    }


}
