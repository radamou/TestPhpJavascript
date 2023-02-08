<?php

namespace App\Entity\Traits;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blame trait.
 *
 * @ORM\MappedSuperclass
 */
trait BlameTrait
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\Column(nullable: false)]
    protected ?User $createdBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\Column(nullable: false)]
    protected ?User $updatedBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\Column(nullable: false)]
    protected ?User $archivedBy = null;

    /**
     * Get created by.
     *
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * Set created by.
     *
     * @param User $createdBy
     *
     * @return self
     */
    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get updated by.
     *
     * @return User|null
     */
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    /**
     * Set updated by.
     *
     * @param User|null $updatedBy User who made the update
     *
     * @return self
     */
    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get archived by.
     *
     * @return User|null
     */
    public function getArchivedBy(): ?User
    {
        return $this->archivedBy;
    }

    /**
     * Set archived by.
     *
     * @param User|null $archivedBy User who made the archive
     *
     * @return self
     */
    public function setArchivedBy(?User $archivedBy): self
    {
        $this->archivedBy = $archivedBy;

        return $this;
    }
}
