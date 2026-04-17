<?php

namespace App\Modules\Catalog\Domain\ValueObjects;

//TODO Вынести в shared
class Meta
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = array_merge([
            'title' => '',
            'description' => '',
        ], $data);
    }

    public static function default(): self
    {
        return new self;
    }

    public function getTitle(): string
    {
        return $this->data['title'] ?? '';
    }

    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function withTitle(string $title): self
    {
        $new = clone $this;
        $new->data['title'] = $title;

        return $new;
    }

    public function withDescription(string $description): self
    {
        $new = clone $this;
        $new->data['description'] = $description;

        return $new;
    }
}
