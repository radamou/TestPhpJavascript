<?php

namespace App\Entity\Traits\Interfaces;

/**
 * IdentifierInterface class.
 */
interface IdentifierInterface
{
    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Get uuid.
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Set Uuid.
     *
     * @param string $uuid Uuid
     *
     * @return self
     */
    public function setUuid(string $uuid): self;
}