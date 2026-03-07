<?php
declare(strict_types=1);

namespace App\Modules\Product\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Product\Entity\Category;
use App\Modules\Product\Repository\CategoryRepository;
use App\Modules\Product\Service\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    private CategoryService $service;
    private CategoryRepository $repository;

    public function __construct(CategoryService $service, CategoryRepository $repository)
    {
        $this->middleware(['auth:api']);
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(): array
    {
        return $this->repository->getTreeIndex();
    }

    //Отдельные акшионс на загрузку данных о категории
    public function show(Category $category): array
    {
        return $this->repository->getCategory($category);
    }
    public function get_children(Category $category): array
    {
        return $this->repository->getChildren($category);
    }
    public function get_attributes(Category $category): array
    {
        return $this->repository->getAttributes($category);
    }
    public function get_products(Category $category): array
    {
        return $this->repository->getProducts($category);
    }

    public function set_info(Category $category, Request $request)
    {
        $this->service->setInfo($request, $category);
        return \response()->json(true);
    }

    public function up(Category $category): JsonResponse
    {
        $category->up();
        return \response()->json(true);
    }

    public function down(Category $category): JsonResponse
    {
        $category->down();
        return \response()->json(true);
    }

/*
    public function child(Category $category)
    {
        return view('admin.product.category.child', compact('category'));
    }
*/
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|integer|exists:categories,id',
        ]);
        $category = $this->service->register($request);
        return \response()->json([
            'ok' => true,
            'id' => $category->id,
        ]);
    }

/*
    public function edit(Category $category)
    {
        $categories = $this->repository->withDepth();
        return view('admin.product.category.edit', compact('category', 'categories'));
    }*/
/*
    public function update(Request $request, Category $category)
    {
        $category = $this->service->update($request, $category);
        return redirect(route('admin.product.category.show', $category));
    }
*/
    public function destroy(Category $category): JsonResponse
    {
        $this->service->delete($category);
        return \response()->json(true);
    }

    public function list(): JsonResponse
    {
        $categories = array_map(function (Category $category) {

            $depth = str_repeat('-', $category->depth);
            return [
                'id' => $category->id,
                'name' => $depth . $category->name,
            ];
        }, $this->repository->withDepth());

        return response()->json($categories);
    }

    public function last_modified()
    {
        return Category::max('updated_at');
    }

}
