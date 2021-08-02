<?php

namespace App\Entities;

use App\Traits\SoftDeletesBehavior;
use App\Traits\TimestampBehavior;
use App\Traits\UsesPasswordGrant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use LaravelDoctrine\ACL\Permissions\Permission;
use \LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use \Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use \Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \LaravelDoctrine\ORM\Notifications\Notifiable;
use \Illuminate\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelDoctrine\ACL\Roles\HasRoles;
use LaravelDoctrine\ACL\Mappings as ACL;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionContract;

/**
 * @ORM\Entity
 */
class User
    extends
    BaseEntity
    implements
    AuthenticatableContract,
    MustVerifyEmailContract,
    CanResetPasswordContract,
    HasRolesContract,
    HasPermissionContract
{
    use Authenticatable,
        Notifiable,
        MustVerifyEmail,
        CanResetPassword,
        Authorizable,
        HasRoles,
        HasPermissions,
        TimestampBehavior,
        SoftDeletesBehavior,
        HasApiTokens,
        HasFactory,
        Notifiable,
        UsesPasswordGrant;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", unique=true, length=60)
     */
    private string $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $emailVerifiedAt;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    private int $agreement;

    /**
     * @ACL\HasRoles()
     * @var \Doctrine\Common\Collections\AbstractLazyCollection|\LaravelDoctrine\ACL\Contracts\Role
     */
    protected $roles;

    /**
     * @ACL\HasPermissions
     */
    public $permissions;

    /**
     * @ORM\OneToOne(targetEntity="UserInformation", mappedBy="user")
     */
    private ?UserInformation $userInformation;

    /**
     * @ORM\OneToOne(targetEntity="TeacherInformation", mappedBy="user")
     */
    private ?TeacherInformation $teacherInformation;

    /**
     * @ORM\ManyToOne(targetEntity="UserGroup")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private ?UserGroup $group;

    /**
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="NO ACTION")
     */
    private ?Currency $baseCurrency;

    /**
     *
     * @ORM\OneToMany(targetEntity="LessonReserve", mappedBy="user")
     */
    private $request;

    /**
     *
     * @ORM\OneToMany(targetEntity="LessonReserve", mappedBy="teacher")
     */
    private $requestTeacher;

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->request = new ArrayCollection();
        $this->requestTeacher = new ArrayCollection();
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
    public function getKey()
    {
        return $this->getId();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return ArrayCollection|Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param string $permission
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmailVerifiedAt()
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param mixed $emailVerifiedAt
     */
    public function setEmailVerifiedAt($emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    /**
     * @return int
     */
    public function getAgreement(): int
    {
        return $this->agreement;
    }

    /**
     * @param int $agreement
     */
    public function setAgreement(int $agreement): void
    {
        $this->agreement = $agreement;
    }

    /**
     * @return UserInformation|null
     */
    public function getUserInformation(): ?UserInformation
    {
        return $this->userInformation;
    }

    /**
     * @param UserInformation $userInformation
     */
    public function setUserInformation(UserInformation $userInformation): void
    {
        $this->userInformation = $userInformation;
    }

    /**
     * @return TeacherInformation|null
     */
    public function getTeacherInformation(): ?TeacherInformation
    {
        return $this->teacherInformation;
    }

    /**
     * @param TeacherInformation $teacherInformation
     */
    public function setTeacherInformation(TeacherInformation $teacherInformation): void
    {
        $this->teacherInformation = $teacherInformation;
    }

    /**
     * @return UserGroup|null
     */
    public function getGroup(): ?UserGroup
    {
        return $this->group;
    }

    /**
     * @param UserGroup $group
     */
    public function setGroup(UserGroup $group): void
    {
        $this->group = $group;
    }

    /**
     * @return Currency|null
     */
    public function getBaseCurrency(): ?Currency
    {
        return $this->baseCurrency;
    }

    /**
     * @param Currency|null $baseCurrency
     */
    public function setBaseCurrency(?Currency $baseCurrency): void
    {
        $this->baseCurrency = $baseCurrency;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getTeacherRequest()
    {
        return $this->requestTeacher;
    }
}
