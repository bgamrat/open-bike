<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Config\Bike\Color;
use App\Config\Bike\Size;
use App\Config\Bike\Status;
use App\Config\Bike\Type;
use App\Entity\BikeRequest;
use App\Repository\BikeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
#[ORM\HasLifecycleCallbacks]
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
    #[ORM\Column(length: 64, nullable: true)]
    private ?string $brand = null;

    #[Assert\Regex(
                pattern: '/^[\w,.! -]{,64}$/',
                normalizer: trim
        )]
    #[ORM\Column(length: 64, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(nullable: true, enumType: Size::class)]
    private ?Size $size = null;

    #[Assert\GreaterThan(0)]
    #[ORM\Column(nullable: true)]
    private ?int $speeds = null;

    #[Assert\GreaterThan(0)]
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $wheelSize = null;

    #[ORM\Column(length: 16, nullable: true, enumType: Color::class)]
    private ?Color $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(nullable: true, enumType: Status::class)]
    private ?Status $status = null;

    #[ORM\Column(nullable: true, enumType: Type::class)]
    private ?Type $type = null;

    /**
     * @var Collection<int, BikeRequest>
     */
    #[ORM\OneToMany(targetEntity: BikeRequest::class, mappedBy: 'bike')]
    private Collection $recipient;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable]
    public ?\DateTimeImmutable $updatedAt = null;

    public function __construct() {
        $this->recipient = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
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

    public function getSize(): ?Size {
        return $this->size;
    }

    public function setSize(?Size $size): static {
        $this->size = $size;

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

    public function getColor(): ?Color {
        return $this->color;
    }

    public function setColor(?Color $color): static {
        $this->color = $color;

        return $this;
    }

    public function getNote(): ?string {
        return $this->note;
    }

    public function setNote(?string $note): static {
        $this->note = $note;

        return $this;
    }

    public function getStatus(): ?Status {
        return $this->status;
    }

    public function setStatus(?Status $status): static {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?Type {
        return $this->type;
    }

    public function setType(?Type $type): static {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, BikeRequest>
     */
    public function getRecipient(): Collection {
        return $this->recipient;
    }

    public function addRecipient(BikeRequest $recipient): static {
        if (!$this->recipient->contains($recipient)) {
            $this->recipient->add($recipient);
            $recipient->setBike($this);
        }

        return $this;
    }

    public function removeRecipient(BikeRequest $recipient): static {
        if ($this->recipient->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getBike() === $this) {
                $recipient->setBike(null);
            }
        }

        return $this;
    }

    public function getFrameSize(): ?Size {
        return $this->frameSize;
    }

    public function setFrameSize(?Size $frameSize): static {
        $this->frameSize = $frameSize;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
