<?php

namespace App\Entity;

use App\Repository\VolunteerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VolunteerRepository::class)]
class Volunteer {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 32)]
    private ?string $firstName = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 32)]
    private ?string $lastName = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $phone = null;

    #[Assert\Email]
    #[ORM\Column(length: 32, nullable: true)]
    private ?string $email = null;

    #[Assert\Regex(
                pattern: '/[\w\'.-]{2,60}\.(png|jpe?g|gif|webp|jfif)$/i',
                message: 'Invalid image file'
        )]
    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $image;

    #[ORM\OneToOne(inversedBy: 'volunteer', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, Shift>
     */
    #[ORM\OneToMany(targetEntity: Shift::class, mappedBy: 'Volunteer')]
    private Collection $shifts;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'host')]
    private Collection $events;

    #[ORM\Column(nullable: true)]
    private ?int $tagId = null;

    public function __construct() {
        $this->shifts = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): static {
        $this->user = $user;

        return $this;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(?string $phone): static {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string {
        if ($this->user !== null) {
            return $this->user->getEmail();
        }
        return $this->email;
    }

    public function setEmail(?string $email): static {
        $this->email = $email;

        return $this;
    }

    public function setImage(?string $file = null): void {
        $this->image = $file;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    /**
     * @return Collection<int, Shift>
     */
    public function getShifts(): Collection {
        return $this->shifts;
    }

    public function addShift(Shift $shift): static {
        if (!$this->shifts->contains($shift)) {
            $this->shifts->add($shift);
            $shift->setVolunteer($this);
        }

        return $this;
    }

    public function removeShift(Shift $shift): static {
        if ($this->shifts->removeElement($shift)) {
            // set the owning side to null (unless already changed)
            if ($shift->getVolunteer() === $this) {
                $shift->setVolunteer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection {
        return $this->events;
    }

    public function addEvent(Event $event): static {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setHost($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getHost() === $this) {
                $event->setHost(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getTagId(): ?int {
        return $this->tagId;
    }

    public function setTagId(?int $tagId): static {
        $this->tagId = $tagId;

        return $this;
    }
}
