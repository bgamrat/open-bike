<?php

namespace App\Entity;

use App\Repository\RecurrenceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Event;

#[ORM\Entity(repositoryClass: RecurrenceRepository::class)]
class Recurrence {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recurrences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\Column]
    private ?DateTime $datetime = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getEvent(): ?Event {
        return $this->event;
    }

    public function setEvent(?Event $event): static {
        $this->event = $event;

        return $this;
    }

    public function getDateTime(): ?DateTime {
        return $this->datetime;
    }

    public function setDateTime(DateTime $datetime): static {
        $this->datetime = $datetime;

        return $this;
    }

    public function __toString(): string {
        return $this->datetime->format('r');
    }
}
