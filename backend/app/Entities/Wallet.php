<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use App\Traits\TimestampBehavior;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallets")
 */
class Wallet extends BaseEntity
{
    use TimestampBehavior;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=36, nullable=false, unique=true)
     */
    private string $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\Currency", inversedBy="wallets")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    private Currency $currency;

}