<?php

namespace App\Modules\Catalog\Infrastructure\Persistence;

use App\Modules\Catalog\Application\Interfaces\CategoryRepositoryInterface;
use App\Modules\Catalog\Infrastructure\Models\CategoryModel;
use App\Modules\Catalog\Domain\Entities\Category;
use App\Modules\Catalog\Domain\ValueObjects\Slug;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function save(Category $category): Category
    {
        $model = $category->getId() ? CategoryModel::find($category->getId()) : new CategoryModel();

        $model->name = $category->getName();
        $model->slug = (string) $category->getSlug();
        $model->svg_icon = $category->getSvgIcon();
        $model->published = $category->isPublished();
        $model->meta = $category->getMeta()->toArray();
        $model->parent_id = $category->getParent()?->getId();

        $model->save();

        // Обновляем Nested Set поля
        CategoryModel::fixTree();

        return $this->hydrate($model);
    }

    public function findById(int $id): ?Category
    {
        $model = CategoryModel::with('textParameters')->find($id);
        return $model ? $this->hydrate($model) : null;
    }

    public function findBySlug(Slug $slug): ?Category
    {
        $model = CategoryModel::with('textParameters')->where('slug', (string) $slug)->first();
        return $model ? $this->hydrate($model) : null;
    }

    public function getAll(): Collection
    {
        return CategoryModel::with('textParameters')->get()->map(fn ($model) => $this->hydrate($model));
    }

    public function getTree(): Collection
    {
        $tree = CategoryModel::defaultOrder()->get()->toTree();
        return $this->hydrateTree($tree);
    }

    public function delete(int $id): bool
    {
        $model = CategoryModel::find($id);
        if (!$model) {
            return false;
        }
        return $model->delete();
    }


    private function hydrate(CategoryModel $model): Category
    {
        $category = new Category(
            $model->name,
            new Slug($model->slug),
            $model->svg_icon,
            $model->published,
        );
        $category->setId($model->id);
        $category->setLft($model->_lft);
        $category->setRgt($model->_rgt);
        $category->setDepth($model->depth);


        return $category;
    }

    private function hydrateTree(Collection $nodes): Collection
    {
        return $nodes->map(function ($node) {
            $category = $this->hydrate($node);
            if ($node->children->isNotEmpty()) {
                $category->setChildren($this->hydrateTree($node->children));
            }
            return $category;
        });
    }

    public function slugExists(Slug $slug, ?int $excludeId = null): bool
    {
        $query = CategoryModel::where('slug', (string) $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->exists();
    }
}
