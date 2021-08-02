<?php

namespace App\Entities;

use App\Traits\TimestampBehavior;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @ORM\Table(name="lessons")
 */
class Lesson extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $meetUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private User $teacher;

    /**
     * @ORM\Column(type="datetime", nullable=false, columnDefinition="timestamp(6) DEFAULT NULL")
     * @Gedmo\Timestampable(on="create")
     * @var DateTime
     */
    protected $lessonTime;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getTeacher(): User
    {
        return $this->teacher;
    }

    /**
     * @param User $teacher
     */
    public function setTeacher(User $teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return DateTime
     */
    public function getLessonTime(): DateTime
    {
        return $this->lessonTime;
    }

    /**
     * @param DateTime $lessonTime
     */
    public function setLessonTime(DateTime $lessonTime): void
    {
        $this->lessonTime = $lessonTime;
    }

    /**
     * @return string|null
     */
    public function getMeetUrl(): ?string
    {
        return $this->meetUrl;
    }

    /**
     * @param string|null $meetUrl
     */
    public function setMeetUrl(?string $meetUrl): void
    {
        $this->meetUrl = $meetUrl;
    }
}
