<?php


namespace App\Entity\Traits;


use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait EntityDatesTrait
 *  @ORM\HasLifecycleCallbacks()
 */
trait EntityDatesTrait
{

    /**
     * @var DateTimeInterface|null
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    protected $dateCreated;

    /**
     * @var DateTimeInterface|null
     *
     * @ORM\Column(name="date_last_updated", type="datetime", nullable=true)
     */
    protected $dateLastUpdated;

    /**
     * @return DateTimeInterface|null
     */
    public function getDateCreated(): ?DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @param DateTimeInterface|null $dateCreated
     * @return EntityDatesTrait
     */
    public function setDateCreated(?DateTimeInterface $dateCreated): EntityDatesTrait
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateLastUpdated(): ?DateTimeInterface
    {
        return $this->dateLastUpdated;
    }

    /**
     * @param DateTimeInterface|null $dateLastUpdated
     * @return EntityDatesTrait
     */
    public function setDateLastUpdated(?DateTimeInterface $dateLastUpdated): EntityDatesTrait
    {
        $this->dateLastUpdated = $dateLastUpdated;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedDateTimes() :void
    {
        $this->setDateLastUpdated(new DateTime());
        if ($this->getDateCreated() == null) {
            $this->setDateCreated(new DateTime());
        }
    }
}