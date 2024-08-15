<?php

namespace App\Entity;

use App\Repository\AgencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgencyRepository::class)]
class Agency {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 128)]
    private ?string $pointOfContact = null;

    #[ORM\Column(length: 128)]
    private ?string $contactPhone = null;

    /**
     * @var Collection<int, Appointment>
     */
    #[ORM\OneToMany(targetEntity: Appointment::class, mappedBy: 'referrer')]
    private Collection $appointments;

    public function __construct() {
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;

        return $this;
    }

    public function getPointOfContact(): ?string {
        return $this->pointOfContact;
    }

    public function setPointOfContact(string $pointOfContact): static {
        $this->pointOfContact = $pointOfContact;

        return $this;
    }

    public function getContactPhone(): ?string {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): static {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): static {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setReferrer($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): static {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getReferrer() === $this) {
                $appointment->setReferrer(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name; 
    }
}
