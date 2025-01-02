<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'gallery', cascade: ['persist'])]
    private Collection $pictures;

    public function __construct() {
        $this->pictures = new ArrayCollection();
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

    /**
     * @return Collection<int, Image>
     */
    public function getPictures(): Collection {
        return $this->pictures;
    }

    public function addPicture(Image $picture): static {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setGallery($this);
        }

        return $this;
    }

    public function removePicture(Image $picture): static {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getGallery() === $this) {
                $picture->setGallery(null);
            }
        }

        return $this;
    }
}
