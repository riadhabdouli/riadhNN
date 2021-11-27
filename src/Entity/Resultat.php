<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultat
 *
 * @ORM\Table(name="resultat")
 * @ORM\Entity
 */
class Resultat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quizId", type="integer", nullable=false)
     */
    private $quizid;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=false)
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizid(): ?int
    {
        return $this->quizid;
    }

    public function setQuizid(int $quizid): self
    {
        $this->quizid = $quizid;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

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


}
