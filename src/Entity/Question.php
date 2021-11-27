<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="question_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $questionId;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="option1", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $option1;

    /**
     * @var string
     *
     * @ORM\Column(name="option2", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $option2;

    /**
     * @var string
     *
     * @ORM\Column(name="option3", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $option3;

    /**
     * @var string
     *
     * @ORM\Column(name="option4", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $option4;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $answer;

    /**
     * @var int
     *
     * @ORM\Column(name="quiz", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $quiz;

    public function getQuestionId(): ?int
    {
        return $this->questionId;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getOption1(): ?string
    {
        return $this->option1;
    }

    public function setOption1(string $option1): self
    {
        $this->option1 = $option1;

        return $this;
    }

    public function getOption2(): ?string
    {
        return $this->option2;
    }

    public function setOption2(string $option2): self
    {
        $this->option2 = $option2;

        return $this;
    }

    public function getOption3(): ?string
    {
        return $this->option3;
    }

    public function setOption3(string $option3): self
    {
        $this->option3 = $option3;

        return $this;
    }

    public function getOption4(): ?string
    {
        return $this->option4;
    }

    public function setOption4(string $option4): self
    {
        $this->option4 = $option4;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getQuiz(): ?int
    {
        return $this->quiz;
    }

    public function setQuiz(int $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

}
