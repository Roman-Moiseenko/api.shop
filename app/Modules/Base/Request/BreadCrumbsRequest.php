<?php
declare(strict_types=1);

namespace App\Modules\Base\Request;

use Illuminate\Foundation\Http\FormRequest;

class BreadCrumbsRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //dd($this->id);
    }

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'route' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Не указан маршрут',
        ];
    }
}
