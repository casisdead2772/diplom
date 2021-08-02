<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampBehavior;

/**
 * @ORM\Entity
 * @ORM\Table(name="countries")
 */
class Country extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $code;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
