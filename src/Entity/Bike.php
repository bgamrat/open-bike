<?php

namespace App\Entity;

use App\Config\Color;
use App\Repository\BikeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
class Bike {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Regex(
                pattern: '/^[A-Z0-9 -]{1,32}$/',
                normalizer: trim
        )]
    #[ORM\Column(length: 32)]
    private ?string $serialNumber = null;

    #[Assert\Regex(
                pattern: '/^[A-Z0-9 -]{,64}$/',
                normalizer: trim
        )]
    #[ORM\Column(length: 64)]
    private ?string $brand = null;

    #[Assert\Regex(
                pattern: '/^[\w,.! -]{,64}$/',
                normalizer: trim
        )]
    #[ORM\Column(length: 64, nullable: true)]
    private ?string $model = null;

    #[Assert\GreaterThan(0)]
    #[ORM\Column]
    private ?int $speeds = null;

    #[Assert\GreaterThan(0)]
    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $wheelSize = null;

    #[ORM\Column(length: 16, nullable: true, enumType: Color::class)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getSerialNumber(): ?string {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): static {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getBrand(): ?string {
        return $this->brand;
    }

    public function setBrand(string $brand): static {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string {
        return $this->model;
    }

    public function setModel(?string $model): static {
        $this->model = $model;

        return $this;
    }

    public function getSpeeds(): ?int {
        return $this->speeds;
    }

    public function setSpeeds(int $speeds): static {
        $this->speeds = $speeds;

        return $this;
    }

    public function getWheelSize(): ?string {
        return $this->wheelSize;
    }

    public function setWheelSize(?string $wheelSize): static {
        $this->wheelSize = $wheelSize;

        return $this;
    }

    public function getColor(): ?string {
        return $this->color;
    }

    public function setColor(string $color): static {
        $this->color = $color;

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
}
