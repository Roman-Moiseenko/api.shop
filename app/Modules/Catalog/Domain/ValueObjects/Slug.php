<?php

namespace App\Modules\Catalog\Domain\ValueObjects;

use Illuminate\Support\Str;

//TODO Вынести в shared
class Slug
{
    private string $value {
        get {
            return $this->value;
        }
    }

    public function __construct($segments)
    {
        if (is_array($segments)) {
            $segments = array_map(fn($s) => Str::slug($s), $segments);
            $this->value = implode('/', array_filter($segments));
        } else {
            $this->value = Str::slug($segments);
        }

        if (empty($this->value)) {
            throw new \InvalidArgumentException('Slug cannot be empty');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Slug $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * Создаёт Slug из родительского Slug и нового сегмента
     */
    public function withParent(Slug $parentSlug): self
    {
        return new self([$parentSlug->getValue(), $this->value]);
    }

    /**
     * Возвращает последний сегмент пути (для отображения)
     */
    public function lastSegment(): string
    {
        $parts = explode('/', $this->value);
        return end($parts);
    }
}
