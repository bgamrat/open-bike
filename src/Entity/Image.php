<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Regex(
                pattern: '/[\w\'.-]{2,60}\.(png|jpe?g|gif|webp|jfif)$/i',
                message: 'Invalid image file'
        )]
    #[ORM\Column(length: 255)]
    private ?string $file = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $altText = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'Pictures')]
    private ?Gallery $gallery = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getFile(): ?string {
        return $this->file;
    }

    public function setFile(string $file): static {
        $this->file = $file;

        return $this;
    }

    public function getAltText(): ?string {
        return $this->altText;
    }

    public function setAltText(?string $altText): static {
        $this->altText = $altText;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): static {
        $this->description = $description;

        return $this;
    }

    public function getGallery(): ?Gallery {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): static {
        $this->gallery = $gallery;

        return $this;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): static {
        $this->title = $title;

        return $this;
    }

    public function __toString() {
        return $this->title;
    }
}
