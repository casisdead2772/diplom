<?php

namespace App\Entities;
use App\Traits\TimestampBehavior;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @ORM\Table(name="lesson_reserves")
 * @ORM\Table(uniqueConstraints={
 *        @UniqueConstraint(
 *            columns={"teacher_id", "user_id", "reserved_time"})
 *    })
 */
class LessonReserve extends BaseEntity
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
    protected $reservedTime;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
    public function getReservedTime(): DateTime
    {
        return $this->reservedTime;
    }

    /**
     * @param DateTime $reserveTime
     */
    public function setReservedTime(DateTime $reserveTime): void
    {
        $this->reservedTime = $reserveTime;
    }
}
