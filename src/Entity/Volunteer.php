<?php

namespace App\Entity;

use App\Repository\VolunteerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolunteerRepository::class)]
class Volunteer {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $firstName = null;

    #[ORM\Column(length: 32)]
    private ?string $lastName = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'volunteer', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, Shift>
     */
    #[ORM\OneToMany(targetEntity: Shift::class, mappedBy: 'Volunteer')]
    private Collection $shifts;

    public function __construct() {
        $this->shifts = new ArrayCollection();
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
}
