<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class MangaTranslation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: Manga::class, inversedBy: 'translations')]
    private ?Manga $manga = null;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'mangaTranslations')]
    private ?Language $language = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'json')]
    private array $chapters = []; // Translated chapters

    // Getters and Fluent Setters

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;
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

    public function getChapters(): array
    {
        return $this->chapters;
    }

    public function setChapters(array $chapters): self
    {
        $this->chapters = $chapters;
        return $this;
    }
}
