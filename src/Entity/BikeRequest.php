<?php

namespace App\Entity;

use App\Config\BikeRequest\Status;
use App\Entity\Agency;
use App\Entity\Bike;
use App\Repository\BikeRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BikeRequestRepository::class)]
#[ORM\UniqueEntity(fields: ['clientName', 'contact'])]
class BikeRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Regex(
                pattern: '/^[a-z] ?[a-z\',. -]{2,60}$/i',
                message: 'requester.name.message.invalid',
                normalizer: trim
        )]
    #[ORM\Column(length: 64)]
    private ?string $clientName = null;

    #[Assert\Regex(
        pattern: '/^[\w ,.()&#@\'?-]{2,124}$/',
        message: 'requester.contact.message.invalid',
        normalizer: trim
    )]
    #[ORM\Column(length: 128)]
    private ?string $contact = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Assert\Regex(
        pattern: '/^[\w\' ,.()&@"?-]{2,32}$/',
        message: 'requester.height.message.invalid',
        normalizer: trim
    )]
    #[ORM\Column(length: 32)]
    private ?string $height = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agency $referrer = null;

    #[ORM\Column(enumType: Status::class)]
    private ?Status $status = Status::Pending;

    #[ORM\ManyToOne(inversedBy: 'recipient')]
    private ?Bike $bike = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getReferrer(): ?Agency
    {
        return $this->referrer;
    }

    public function setReferrer(?Agency $referrer): static
    {
        $this->referrer = $referrer;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBike(): ?Bike
    {
        return $this->bike;
    }

    public function setBike(?Bike $bike): static
    {
        $this->bike = $bike;

        return $this;
    }

    public function __toString() {
        return \sprintf('%s (%s)',$this->clientName,$this->contact);
    }
}
