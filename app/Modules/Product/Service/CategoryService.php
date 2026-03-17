<?php
declare(strict_types=1);

namespace App\Modules\Product\Service;

use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Helpers\CacheHelper;
use App\Modules\Product\Entity\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryService
{

    public function register(Request $request): Category
    {
        $category = Category::register(
            $request->string('name')->trim()->value(),
            $request['parent_id'] ?? null,
            $request->string('slug')->trim()->value(),
        );
        $this->clearCache();
        return $category;
    }

    public function setInfo(Request $request, Category $category): void
    {
        $category->name = $request->string('name')->trim()->value();
        if ($request->has('parent_id')) {
            $category->parent_id = (int)$request['parent_id'] == 0 ? null : (int)$request['parent_id'];
        }
        $new_slug = $request->string('slug')->trim()->value();

        if ($category->slug != $new_slug) {
            if (empty($new_slug)) {
                $new_slug = Str::slug($category->name);
                if (!empty(Category::where('slug', $new_slug)->first())) {
                    if (!is_null($category->parent_id)) {
                        $new_slug .= '-' . $category->parent->slug;
                    } else {
                        $new_slug .= Str::random(4);
                    }
                }
            }
            $category->slug = $new_slug;
        }

        $category->svg = $request->string('svg')->trim()->value();
        $category->meta = Meta::fromArray($request->input('meta', []));
        $category->save();

        $category->parameters()->detach();
        foreach ($request->input('parameters') as $parameter) {
            $category->parameters()->attach($parameter['parameter_id'], ['text' => $parameter['text'] ?? '']);
        }

        $this->clearCache();
    }
    public function setImage(Request $request, Category $category): void
    {
        $category->saveImageVue($request);
        $category->saveIconVue($request);
    }

    public function delete(Category $category): void
    {
        if (count($category->children) == 0) {
            Category::destroy($category->id);
            $this->clearCache();
        } else {
            throw new \DomainException('Нельзя удалить категорию с подкатегориями');
        }
    }

    private function clearCache(): void
    {
        Cache::put(CacheHelper::MENU_CATEGORIES, '', -1);
        Cache::put(CacheHelper::MENU_TREES, '', -1);
    }
}
