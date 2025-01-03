<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[Assert\Email]
    #[ORM\Column(length: 64)]
    private ?string $email = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $phone = null;

    #[Assert\WordCount(min: 10, max: 1200)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $dt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Gedmo\Timestampable]
    private ?DateTimeInterface $update_dt = null;

    public function __construct() {
	$this->dt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getDt(): ?DateTimeImmutable
    {
        return $this->dt;
    }

    public function setDt(DateTimeImmutable $dt): static
    {
        $this->dt = $dt;

        return $this;
    }

    public function getUpdateDt(): ?DateTimeInterface
    {
        return $this->update_dt;
    }

    public function setUpdateDt(?DateTimeInterface $update_dt): static
    {
        $this->update_dt = $update_dt;

        return $this;
    }
}
