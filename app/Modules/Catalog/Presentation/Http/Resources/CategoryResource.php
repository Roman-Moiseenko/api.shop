<?php

namespace App\Modules\Catalog\Presentation\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class CategoryResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'slug' => (string) $this->getSlug(),
            'svg_icon' => $this->getSvgIcon(),
            'published' => $this->isPublished(),
            'parent_id' => $this->getParent()?->getId(),
            'depth' => $this->getDepth(),
            'children' => $this->when($this->getChildren()->isNotEmpty(),
                CategoryResource::collection($this->getChildren())
            ),
        ];
    }
}
