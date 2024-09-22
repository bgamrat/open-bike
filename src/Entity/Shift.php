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
    private ?DateTimeInterface $startTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endDateTime = null;

    #[ORM\ManyToOne(inversedBy: 'shifts')]
    private ?Volunteer $Volunteer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;

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
}
