<?php

namespace App\Modules\Catalog\Application\Interfaces;

use App\Modules\Catalog\Domain\Entities\Category;
use App\Modules\Catalog\Domain\ValueObjects\Slug;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function save(Category $category): Category;

    public function findById(int $id): ?Category;

    public function findBySlug(Slug $slug): ?Category;

    public function getAll(): Collection;

    public function getTree(): Collection;

    public function delete(int $id): bool;
    public function slugExists(Slug $slug, ?int $excludeId = null): bool;
}
