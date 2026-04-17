<?php

namespace App\Modules\Catalog\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Catalog\Application\DTOs\CategoryDTO;
use App\Modules\Catalog\Presentation\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class CategoryController extends Controller
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CreateCategoryUseCase $createCategoryUseCase,
        private UpdateCategoryUseCase $updateCategoryUseCase
    ) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->getTree();
        return CategoryResource::collection($categories)->response();
    }

    public function show(string $slug): JsonResponse
    {
        $category = $this->categoryRepository->findBySlug(new Slug($slug));
        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
        return (new CategoryResource($category))->response();
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $dto = new CategoryDTO(...$request->validated());
        $category = $this->createCategoryUseCase->execute($dto);
        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $dto = new CategoryDTO(...$request->validated());
        $category = $this->updateCategoryUseCase->execute($id, $dto);
        return (new CategoryResource($category))->response();
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->categoryRepository->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
