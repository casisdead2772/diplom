<?php

namespace App\Entities;

use App\Traits\TimestampBehavior;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @ORM\Table(name="zoom_meet_sessions")
 */
class ZoomMeetSession extends BaseEntity
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
     * @ORM\JoinColumn(name="host_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private User $host;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Lesson")
     * @ORM\JoinColumn(name="lesson_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private Lesson $lesson;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\ZoomMeet")
     * @ORM\JoinColumn(name="zoom_meet_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private ZoomMeet $zoomMeet;

    /**
     * @ORM\Column(type="datetime", nullable=false, columnDefinition="timestamp(6) DEFAULT NULL")
     * @Gedmo\Timestampable(on="create")
     * @var DateTime
     */
    protected $startedTime;

    /**
     * @ORM\Column(type="datetime", nullable=false, columnDefinition="timestamp(6) DEFAULT NULL")
     * @Gedmo\Timestampable(on="create")
     * @var DateTime
     */
    protected $finishedTime;

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
    public function getHost(): User
    {
        return $this->host;
    }

    /**
     * @param User $host
     */
    public function setHost(User $host): void
    {
        $this->host = $host;
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
     * @return Lesson
     */
    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     */
    public function setLesson(Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    /**
     * @return ZoomMeet
     */
    public function getZoomMeet(): ZoomMeet
    {
        return $this->zoomMeet;
    }

    /**
     * @param ZoomMeet $zoomMeet
     */
    public function setZoomMeet(ZoomMeet $zoomMeet): void
    {
        $this->zoomMeet = $zoomMeet;
    }

    /**
     * @return DateTime
     */
    public function getStartedTime(): DateTime
    {
        return $this->startedTime;
    }

    /**
     * @param DateTime $startedTime
     */
    public function setStartedTime(DateTime $startedTime): void
    {
        $this->startedTime = $startedTime;
    }

    /**
     * @return DateTime
     */
    public function getFinishedTime(): DateTime
    {
        return $this->finishedTime;
    }

    /**
     * @param DateTime $finishedTime
     */
    public function setFinishedTime(DateTime $finishedTime): void
    {
        $this->finishedTime = $finishedTime;
    }
}