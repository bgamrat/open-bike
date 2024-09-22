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
     * @var Collection<int, BikeRequest>
     */
    #[ORM\OneToMany(targetEntity: BikeRequest::class, mappedBy: 'referrer')]
    private Collection $bikeRequests;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $contactEmail = null;

    public function __construct() {
        $this->bikeRequests = new ArrayCollection();
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
     * @return Collection<int, BikeRequest>
     */
    public function getBikeRequests(): Collection {
        return $this->bikeRequests;
    }

    public function addBikeRequest(BikeRequest $bikeRequest): static {
        if (!$this->bikeRequests->contains($bikeRequest)) {
            $this->bikeRequests->add($bikeRequest);
            $bikeRequest->setReferrer($this);
        }

        return $this;
    }

    public function removeBikeRequest(BikeRequest $bikeRequest): static {
        if ($this->bikeRequests->removeElement($bikeRequest)) {
            // set the owning side to null (unless already changed)
            if ($bikeRequest->getReferrer() === $this) {
                $bikeRequest->setReferrer(null);
            }
        }

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
