<?php

namespace App\Entities;

use App\Traits\TimestampBehavior;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="teacher_informations")
 */
class TeacherInformation extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $shortDescription;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $pricePerHour;

    /**
     * @ORM\OneToOne(targetEntity="App\Entities\User", inversedBy="teacherInformation")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Specialty")
     * @ORM\JoinColumn(name="specialty_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private Specialty $specialty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", onDelete="NO ACTION")
     */
   private Country $country;

    /**
     * @ORM\OneToMany(targetEntity="TeacherInformationLanguageGrade", mappedBy="teacherInformation")
     */
    private $teacherLanguages;

    public function __construct()
    {
        $this->teacherLanguages = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string|null $shortDescription
     */
    public function setShortDescription(?string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return int
     */
    public function getPricePerHour(): int
    {
        return $this->pricePerHour;
    }

    /**
     * @param int $pricePerHour
     */
    public function setPricePerHour(int $pricePerHour): void
    {
        $this->pricePerHour = $pricePerHour;
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
     * @return Specialty
     */
    public function getSpecialty(): Specialty
    {
        return $this->specialty;
    }

    /**
     * @param Specialty $specialty
     */
    public function setSpecialty(Specialty $specialty): void
    {
        $this->specialty = $specialty;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    public function getTeacherLanguages()
    {
        return $this->teacherLanguages;
    }
}
