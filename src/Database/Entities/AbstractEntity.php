<?php

namespace App\Database\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class AbstractEntity
{
    #[ORM\Column]
    #[ORM\GeneratedValue]
    #[ORM\Id]
    protected int $id;

    #[ORM\Column(name: 'created_at')]
    protected DateTime $createdAt;

    #[ORM\Column(name: 'updated_at')]
    protected DateTime $updatedAt;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $currentDateTime = new DateTime();

        if (!isset($this->createdAt)) {
            $this->createdAt = $currentDateTime;
        }

        $this->updatedAt = $currentDateTime;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
