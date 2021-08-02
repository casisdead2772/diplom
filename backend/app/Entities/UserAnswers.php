<?php


namespace App\Entities;

use App\Traits\TimestampBehavior;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_answers")
 */
class UserAnswers extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Answers")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private Answers $answer;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private Question $question;

    /**
     * @ORM\ManyToOne(targetEntity="QuizAttempt")
     * @ORM\JoinColumn(name="quiz_attempt_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private QuizAttempt $quizAttempt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Answers
     */
    public function getAnswer(): Answers
    {
        return $this->answer;
    }

    /**
     * @param Answers $answer
     */
    public function setAnswer(Answers $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return Question
     */
    public function getUser(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setUser(Question $question): void
    {
        $this->question = $question;
    }

    /**
     * @return QuizAttempt
     */
    public function getQuizAttempt(): QuizAttempt
    {
        return $this->quizAttempt;
    }

    /**
     * @param QuizAttempt $quizAttempt
     */
    public function setQuizAttempt(QuizAttempt $quizAttempt): void
    {
        $this->quizAttempt = $quizAttempt;
    }

}
