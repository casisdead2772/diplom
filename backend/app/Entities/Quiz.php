<?php


namespace App\Entities;

use App\Traits\TimestampBehavior;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
     * @ORM\Table(name="quizzes")
 */
class Quiz extends BaseEntity
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
    private string $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private User $teacher;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="quiz", cascade={"remove"})
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();

    }

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
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->teacher;
    }

    /**
     * @param User $teacher
     */
    public function setUser(User $teacher): void
    {
        $this->teacher = $teacher;
    }

    public function getQuestion()
    {
        return $this->questions;
    }

    public function setQuestion($question)
    {
        $this->question = $question;
    }
}
