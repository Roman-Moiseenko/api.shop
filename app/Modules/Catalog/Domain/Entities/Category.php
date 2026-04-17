<?php

namespace App\Modules\Catalog\Domain\Entities;

use App\Modules\Catalog\Domain\ValueObjects\Meta;
use App\Modules\Catalog\Domain\ValueObjects\Slug;
use Illuminate\Support\Collection;

class Category
{
    private ?int $id = null;
    private string $name;
    private Slug $slug;
    private ?string $svgIcon;
    private bool $published;
    private ?Category $parent = null;
    private Collection $children;
    private int $lft = 0;
    private int $rgt = 0;
    private int $depth = 0;
    public function __construct(
        string $name,
        Slug $slug,
        ?string $svgIcon = null,
        bool $published = false,
    ) {
        $this->name = $name;
        $this->slug = $slug;
        $this->svgIcon = $svgIcon;
        $this->published = $published;
        $this->children = new Collection;
    }

    // Геттеры и методы для работы с Nested Set
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): Slug
    {
        return $this->slug;
    }

    public function getSvgIcon(): ?string
    {
        return $this->svgIcon;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getLft(): int
    {
        return $this->lft;
    }

    public function getRgt(): int
    {
        return $this->rgt;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    // Методы для установки свойств, используемые репозиторием
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setParent(?Category $parent): void
    {
        $this->parent = $parent;
    }

    public function setChildren(Collection $children): void
    {
        $this->children = $children;
    }

    public function setLft(int $lft): void
    {
        $this->lft = $lft;
    }

    public function setRgt(int $rgt): void
    {
        $this->rgt = $rgt;
    }

    public function setDepth(int $depth): void
    {
        $this->depth = $depth;
    }

    public function publish(): void
    {
        $this->published = true;
    }

    public function unpublish(): void
    {
        $this->published = false;
    }

    public function isRoot(): bool
    {
        return $this->parent === null;
    }

    public function hasChildren(): bool
    {
        return $this->children->isNotEmpty();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSvgIcon(?string $svgIcon): void
    {
        $this->svgIcon = $svgIcon;
    }

    public function setSlug(Slug $slug)
    {
        $this->slug = $slug;
    }
}
