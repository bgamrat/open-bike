<?php

namespace App\Entity;

use App\Repository\ShiftRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShiftRepository::class)]
class Shift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $startDateTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endDateTime = null;

    #[ORM\ManyToOne(inversedBy: 'shifts')]
    private ?Volunteer $Volunteer = null;

    #[ORM\Column(nullable: true)]
    private ?bool $adjusted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateTime(): ?DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeInterface $startDateTime): static
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?DateTimeInterface $endDateTime): static
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getVolunteer(): ?Volunteer
    {
        return $this->Volunteer;
    }

    public function setVolunteer(?Volunteer $Volunteer): static
    {
        $this->Volunteer = $Volunteer;

        return $this;
    }

    public function isAdjusted(): ?bool
    {
        return $this->adjusted;
    }

    public function setAdjusted(?bool $adjusted): static
    {
        $this->adjusted = $adjusted;

        return $this;
    }
}
