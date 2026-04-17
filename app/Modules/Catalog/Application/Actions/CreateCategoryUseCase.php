<?php

namespace App\Modules\Catalog\Application\Actions;

use App\Modules\Catalog\Application\DTOs\CategoryDTO;
use App\Modules\Catalog\Application\Interfaces\CategoryRepositoryInterface;
use App\Modules\Catalog\Domain\Entities\Category;
use App\Modules\Catalog\Domain\ValueObjects\Slug;

class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {}

    public function execute(CategoryDTO $dto): Category
    {
        // 1. Базовый slug из входных данных
        $baseSlug = new Slug($dto->slug);
        $slug = $baseSlug;

        // 2. Поиск родительской категории, если указан parent_id
        $parent = null;
        if ($dto->parentId) {
            $parent = $this->categoryRepository->findById($dto->parentId);
            if (!$parent) {
                throw new \InvalidArgumentException('Родительская категория не найдена');
            }
        }

        // 3. Проверка уникальности slug
        if ($this->categoryRepository->slugExists($slug)) {
            if ($parent) {
                // Формируем составной slug: родительский_slug/базовый_slug
                $slug = $baseSlug->withParent($parent->getSlug());

                // Проверяем уникальность составного slug
                if ($this->categoryRepository->slugExists($slug)) {
                    // Если даже составной slug существует, добавляем суффикс (на всякий случай)
                    $slug = $this->makeUniqueSlug($slug);
                }
            } else {
                // Корневая категория с неуникальным slug
                throw new SlugNotUniqueException("Slug '{$baseSlug}' уже существует для корневой категории. Укажите родительскую категорию или измените slug.");
            }
        }

        // 4. Создание сущности
        $meta = new Meta($dto->meta);
        $category = new Category(
            $dto->name,
            $slug,
            $dto->svgIcon,
            $dto->published,
            $meta
        );

        if ($parent) {
            $category->setParent($parent);
        }

        $savedCategory = $this->categoryRepository->save($category);



        return $savedCategory;
    }

    /**
     * Добавляет числовой суффикс для обеспечения уникальности
     */
    private function makeUniqueSlug(Slug $slug): Slug
    {
        $base = $slug->getValue();
        $counter = 1;
        do {
            $newSlug = new Slug($base . '-' . $counter);
            $counter++;
        } while ($this->categoryRepository->slugExists($newSlug));

        return $newSlug;
    }
}
