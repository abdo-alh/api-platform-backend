<?php

namespace App\Entity;

use DateTimeInterface;

trait Timesampable 
{
    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"article_read","user_details_read","article_details_read"})
     */
    private $updatedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}