<?php

namespace App\Entity\Traits\Interfaces;

use DateTimeInterface;

interface TimestampInterface
{
    /**
     * Get created at.
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface;

    /**
     * Set created at.
     *
     * @param DateTimeInterface $createdAt Creation date
     *
     * @return self
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self;

    /**
     * Get updated at.
     *
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * Set updated at.
     *
     * @param DateTimeInterface $updatedAt Date of update
     *
     * @return self
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self;

    /**
     * Get archived at.
     *
     * @return DateTimeInterface|null
     */
    public function getArchivedAt(): ?DateTimeInterface;

    /**
     * Set archived at.
     *
     * @param DateTimeInterface|null $archivedAt Date of archive
     *
     * @return self
     */
    public function setArchivedAt(?DateTimeInterface $archivedAt): self;

    /**
     * Init "created date" and update "updated date".
     *
     * @return self
     */
    public function updateTimestamps(): self;
}
