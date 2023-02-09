<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\User;

interface BlameInterface
{
    /**
     * Get user who created the entity.
     *
     * @return User|null
     */
    public function getCreatedBy(): ?User;

    /**
     * Set user who created the entity.
     *
     * @param User $createdBy User
     *
     * @return self
     */
    public function setCreatedBy(?User $user): self;

    /**
     * Get user who updated the entity.
     *
     * @return User|null
     */
    public function getUpdatedBy(): ?User;

    /**
     * Set updated by.
     *
     * @param User|null $updatedBy User who made the update
     *
     * @return self
     */
    public function setUpdatedBy(?User $user): self;

    /**
     * Get user who archived the entity.
     *
     * @return User|null
     */
    public function getArchivedBy(): ?User;

    /**
     * Set user who archived the entity.
     *
     * @param User|null $archivedBy User
     *
     * @return self
     */
    public function setArchivedBy(?User $archivedBy): self;
}
