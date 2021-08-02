<?php

namespace App\Entities;

use App\Traits\TimestampBehavior;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Permission;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Mappings as ACL;

/**
 * @ORM\Entity()
 */
class Role implements RoleContract
{
    use TimestampBehavior, HasPermissions;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected string $name;

    /**
     * @ACL\HasPermissions
     */
    public $permissions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entities\User", mappedBy="roles")
     */
    private $users;

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
    public function hasPermissionTo($permission)
    {
        // TODO: Implement hasPermissionTo() method.
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
    public function setPermissions(string $permissions): void
    {
        $this->permissions = $permissions;
    }
}