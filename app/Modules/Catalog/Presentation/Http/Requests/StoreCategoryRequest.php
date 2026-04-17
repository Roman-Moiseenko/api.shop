<?php

namespace App\Modules\Catalog\Presentation\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'svg_icon' => 'nullable|string',
            'published' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}
