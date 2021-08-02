<?php

namespace App\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait  TimestampBehavior
{
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false, columnDefinition="timestamp(6) DEFAULT 0")
     * @Gedmo\Timestampable(on="create")
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, columnDefinition="timestamp(6) DEFAULT 0")
     * @Gedmo\Timestampable(on="update")
     * @var DateTime
     */
    protected $updatedAt;


    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setCreatedAt( $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt( $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
