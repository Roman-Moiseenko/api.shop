<?php

namespace App\Modules\Catalog\Application\Actions;

use App\Modules\Catalog\Application\DTOs\CategoryDTO;
use App\Modules\Catalog\Application\Interfaces\CategoryRepositoryInterface;
use App\Modules\Catalog\Domain\Entities\Category;
use App\Modules\Catalog\Domain\ValueObjects\Slug;

class UpdateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {}

    public function execute(int $categoryId, CategoryDTO $dto): Category
    {
        $category = $this->categoryRepository->findById($categoryId);
        if (!$category) {
            throw new \InvalidArgumentException('Категория не найдена');
        }

        // 1. Обновление базовых полей
        $category->setName($dto->name);
        $category->setSvgIcon($dto->svgIcon);

        if ($dto->published) {
            $category->publish();
        } else {
            $category->unpublish();
        }

        // 2. Обработка slug
        $newBaseSlug = new Slug($dto->slug);
        $currentSlug = $category->getSlug();

        // Определяем, изменился ли slug или parent
        $parentChanged = $category->getParent()?->getId() !== $dto->parentId;
        $slugChanged = !$newBaseSlug->equals($currentSlug);

        if ($slugChanged || $parentChanged) {
            $slug = $newBaseSlug;

            // Поиск нового родителя
            $parent = null;
            if ($dto->parentId) {
                $parent = $this->categoryRepository->findById($dto->parentId);
                if (!$parent) {
                    throw new \InvalidArgumentException('Родительская категория не найдена');
                }
                // Проверка на циклическую зависимость
                if ($parent->getId() === $categoryId) {
                    throw new \InvalidArgumentException('Категория не может быть родителем самой себе');
                }
            }

            // Проверка уникальности slug
            if ($this->categoryRepository->slugExists($slug, $categoryId)) {
                if ($parent) {
                    $slug = $newBaseSlug->withParent($parent->getSlug());
                    if ($this->categoryRepository->slugExists($slug, $categoryId)) {
                        $slug = $this->makeUniqueSlug($slug, $categoryId);
                    }
                } else {
                    throw new SlugNotUniqueException("Slug '{$newBaseSlug}' уже существует для корневой категории. Укажите родительскую категорию или измените slug.");
                }
            }

            $category->setSlug($slug);
            $category->setParent($parent);
        }

        // 3. Сохранение
        return $this->categoryRepository->save($category);
    }

    private function makeUniqueSlug(Slug $slug, int $excludeId): Slug
    {
        $base = $slug->getValue();
        $counter = 1;
        do {
            $newSlug = new Slug($base . '-' . $counter);
            $counter++;
        } while ($this->categoryRepository->slugExists($newSlug, $excludeId));

        return $newSlug;
    }
}
