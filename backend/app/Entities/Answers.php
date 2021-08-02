<?php


namespace App\Entities;

use App\Traits\TimestampBehavior;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="answers")
 */
class Answers extends BaseEntity
{

    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $answerTitle;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private int $correct;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private Question $question;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->answerTitle;
    }

    /**
     * @param string $answerTitle
     */
    public function setTitle(string $answerTitle): void
    {
        $this->answerTitle = $answerTitle;
    }

    /**
     * @return int
     */
    public function getCorrect(): int
    {
        return $this->correct;
    }

    /**
     * @param int $correct
     */
    public function setCorrect(int $correct): void
    {
        $this->correct = $correct;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

}
