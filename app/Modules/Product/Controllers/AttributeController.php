<?php

declare(strict_types=1);

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Entity\Attribute;
use App\Modules\Product\Entity\AttributeGroup;
use App\Modules\Product\Repository\AttributeGroupRepository;
use App\Modules\Product\Repository\AttributeRepository;
use App\Modules\Product\Repository\CategoryRepository;
use App\Modules\Product\Service\AttributeGroupService;
use App\Modules\Product\Service\AttributeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    private AttributeService $service;

    private AttributeGroupService $groupService;

    private CategoryRepository $categories;

    private AttributeRepository $repository;

    private AttributeGroupRepository $groupRepository;

    public function __construct(
        AttributeService $service,
        AttributeGroupService $groupService,
        CategoryRepository $categories,
        AttributeRepository $repository,
        AttributeGroupRepository $groupRepository,
    ) {
        $this->middleware(['auth:api']);
        $this->service = $service;
        $this->groupService = $groupService;
        $this->categories = $categories;
        $this->repository = $repository;
        $this->groupRepository = $groupRepository;
    }

    public function index(Request $request): JsonResponse
    {
        // $categories = $this->categories->forFilters();
        // $groups = $this->groupRepository->get(order_by: 'name');
        $attributes = $this->repository->getIndex($request, $filters);

        return response()->json($attributes);

        /*
        return response()->json([
            'attributes' => $attributes,
            'filters' => $filters,
            'categories' => $categories,
            'groups' => $groups,
            'types' => array_select(Attribute::ATTRIBUTES),
        ]);
        */
    }

    public function guide(): JsonResponse
    {
        return response()->json(array_select(Attribute::ATTRIBUTES, Attribute::TYPE_VARIANT));
    }

    public function groups(Request $request): JsonResponse
    {
        $groups = $this->groupRepository->get(order_by: 'name');

        return response()->json($groups);
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'categories' => 'required|array',
            'group_id' => 'required|integer',
            'name' => 'required|string',
            'type' => 'required|integer',
        ]);

        $attribute = $this->service->create($request);

        return \response()->json([
            'ok' => true,
            'id' => $attribute->id,
        ]);

    }

    public function show(Attribute $attribute): JsonResponse
    {
        //    $categories = $this->categories->forFilters();
        //   $groups = $this->groupRepository->get(order_by: 'name');

        return response()->json($this->repository->AttributeWithToArray($attribute));
        /*
                return Inertia::render('Product/Attribute/Show', [
                    'attribute' => $this->repository->AttributeWithToArray($attribute),
                    'categories' => $categories,
                    'groups' => $groups,
                    'types' => array_select(Attribute::ATTRIBUTES),
                    'variant' => Attribute::TYPE_VARIANT,
                ]);
                */
    }

    public function set_info(Request $request, Attribute $attribute): JsonResponse
    {
        $this->service->setInfo($request, $attribute);

        return \response()->json(true);
    }

    public function destroy(Attribute $attribute): JsonResponse
    {
        $this->service->delete($attribute);

        return \response()->json(true);
    }

    // ГРУППЫ АТРИБУТОВ
    public function group_add(Request $request): JsonResponse
    {
        $group = $this->groupService->create($request);

        return \response()->json([
            'ok' => true,
            'id' => $group->id,
        ]);

    }

    public function group_up(AttributeGroup $group): JsonResponse
    {
        $this->groupService->up($group);

        return \response()->json(true);
    }

    public function group_down(AttributeGroup $group): JsonResponse
    {
        $this->groupService->down($group);

        return \response()->json(true);

    }

    public function group_rename(Request $request, AttributeGroup $group): JsonResponse
    {
        $this->groupService->update($request, $group);

        return \response()->json(true);
    }

    public function group_destroy(AttributeGroup $group): JsonResponse
    {
        $this->groupService->delete($group);

        return \response()->json(true);
    }

    /*
    //Варианты
    public function variant_image(Request $request, AttributeVariant $variant)
    {
        $this->service->image_variant($variant, $request);
        return redirect()->back();
    }*/
}
