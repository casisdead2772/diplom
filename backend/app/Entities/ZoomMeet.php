<?php

namespace App\Entities;

namespace App\Entities;
use App\Traits\TimestampBehavior;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity
 * @ORM\Table(name="zoom_meets")
 */
class ZoomMeet extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=false, unique=true)
     */
    private int $meetNumber;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, unique=true)
     */
    private string $meetPassword;

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
    public function getMeetNumber(): int
    {
        return $this->meetNumber;
    }

    /**
     * @param int $meetNumber
     */
    public function setMeetNumber(int $meetNumber): void
    {
        $this->meetNumber = $meetNumber;
    }

    /**
     * @return string
     */
    public function getMeetPassword(): string
    {
        return $this->meetPassword;
    }

    /**
     * @param string $meetPassword
     */
    public function setMeetPassword(string $meetPassword): void
    {
        $this->meetPassword = $meetPassword;
    }
}