<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Chapter
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'integer')]
    private int $chapterNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $releaseDate;

    #[ORM\Column(type: 'json')]
    private array $pages = []; // Array of image URLs

    #[ORM\ManyToOne(targetEntity: Manga::class, inversedBy: 'chapters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manga $manga = null;

    public function __construct()
    {
        $this->releaseDate = new \DateTimeImmutable();
    }

    // Getters and Fluent Setters

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getChapterNumber(): int
    {
        return $this->chapterNumber;
    }

    public function setChapterNumber(int $chapterNumber): self
    {
        $this->chapterNumber = $chapterNumber;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getReleaseDate(): \DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function setPages(array $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;
        return $this;
    }
}
