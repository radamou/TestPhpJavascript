<?php

namespace App\Entity\Traits;

use App\Entity\Traits\Interfaces\TimestampInterface;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\HasLifecycleCallbacks]
#[ORM\MappedSuperclass]
trait TimestampTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    protected ?DateTimeInterface $archivedAt = null;

    /**
     * Get created at.
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set created at.
     *
     * @param DateTimeInterface $createdAt Creation date
     *
     * @return TimestampInterface
     */
    public function setCreatedAt(DateTimeInterface $createdAt): TimestampInterface
    {
        if ($this->createdAt != $createdAt) {
            $this->createdAt = $createdAt;
        }

        return $this;
    }

    /**
     * Get updated at.
     *
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set updated at.
     *
     * @param DateTimeInterface $updatedAt Date of update
     *
     * @return TimestampInterface
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): TimestampInterface
    {
        if ($this->updatedAt != $updatedAt) {
            $this->updatedAt = $updatedAt;
        }

        return $this;
    }

    /**
     * Get archived at.
     *
     * @return DateTimeInterface|null
     */
    public function getArchivedAt(): ?DateTimeInterface
    {
        return $this->archivedAt;
    }

    /**
     * Set archived at.
     *
     * @param DateTimeInterface|null $archivedAt Date of archive
     *
     * @return TimestampInterface
     */
    public function setArchivedAt(?DateTimeInterface $archivedAt): TimestampInterface
    {
        if ($this->archivedAt != $archivedAt) {
            $this->archivedAt = $archivedAt;
        }

        return $this;
    }

    /**
     * Init "created date" and update "updated date".
     *
     * @return TimestampInterface
     *
     * @throws Exception
     */
    #[ORM\PostUpdate]
    #[ORM\PrePersist]
    public function updateTimestamps(): TimestampInterface
    {
        $dateTime = new \DateTimeImmutable();
        $this->setUpdatedAt($dateTime);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTime);
        }

        return $this;
    }

    /**
     * Return archived status of current entity.
     *
     * @return string
     */
    public function getArchiveStatus(): string
    {
        return $this->getArchivedAt() === null ? 'Active' : 'Archived';
    }
}
