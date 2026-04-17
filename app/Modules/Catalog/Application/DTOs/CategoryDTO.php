<?php

namespace App\Modules\Catalog\Application\DTOs;

class CategoryDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $svgIcon = null,
        public readonly bool $published = false,
        public readonly ?int $parentId = null,
    ) {}
}
