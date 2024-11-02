<?php

namespace App\Entity;

use App\Config\Event\Type;
use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: Type::class)]
    private ?Type $type = null;

    #[ORM\Column(length: 128)]
    #[Assert\Regex(
                pattern: '/^[\w\',. ()-]{5,128}$/i',
                message: 'requester.name.message.invalid',
                normalizer: trim
        )]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $end = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Volunteer $host = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getType(): ?Type {
        return $this->type;
    }

    public function setType(Type $type): static {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;

        return $this;
    }

    public function getStart(): ?DateTimeInterface {
        return $this->start;
    }

    public function setStart(DateTimeInterface $start): static {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?DateTimeInterface {
        return $this->end;
    }

    public function setEnd(DateTimeInterface $end): static {
        $this->end = $end;

        return $this;
    }

    public function getNote(): ?string {
        return $this->note;
    }

    public function setNote(?string $note): static {
        $this->note = $note;

        return $this;
    }

    public function getHost(): ?Volunteer
    {
        return $this->host;
    }

    public function setHost(?Volunteer $host): static
    {
        $this->host = $host;

        return $this;
    }
}