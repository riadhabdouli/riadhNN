<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity
 */
class Quiz
{
    /**
     * @var int
     *
     * @ORM\Column(name="quizId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $quizid;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $title;

    public function getQuizid(): ?int
    {
        return $this->quizid;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


}
