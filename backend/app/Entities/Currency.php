<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampBehavior;

/**
 * @ORM\Entity
 * @ORM\Table(name="currencies")
 */
class Currency extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="smallint", nullable=false, name="`precision`")
     */
    private int $precision;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $status;

    /**
     * @ORM\Column(type="string", length=25, nullable=false, unique=true)
     */
    private string $code;

    /**
     * @ORM\Column(type="string", length=6, nullable=false) // example USD
     */
    private string $shortCode;

    /**
     * @ORM\Column(columnDefinition="TINYINT NOT NULL")
     */
    private int $type;

    /**
     *
     * @ORM\OneToMany(targetEntity="Wallet", mappedBy="currency")
     */
    private $wallets;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\File")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private ?File $file;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default" : 0})
     */
    private int $isSystem;

    public function __construct()
    {
        $this->wallets = new ArrayCollection();
    }

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
    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * @param int $precision
     */
    public function setPrecision(int $precision): void
    {
        $this->precision = $precision;
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

    /**
     * @return string
     */
    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    /**
     * @param string $shortCode
     */
    public function setShortCode(string $shortCode): void
    {
        $this->shortCode = $shortCode;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection
     */
    public function getWallets(): ArrayCollection
    {
        return $this->wallets;
    }

    /**
     * @param ArrayCollection $wallets
     */
    public function setWallets(ArrayCollection $wallets): void
    {
        $this->wallets = $wallets;
    }

    /**
     * @return int
     */
    public function getIsSystem(): int
    {
        return $this->isSystem;
    }

    /**
     * @param int $isSystem
     */
    public function setIsSystem(int $isSystem): void
    {
        $this->isSystem = $isSystem;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }
}