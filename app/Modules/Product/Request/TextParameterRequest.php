<?php
declare(strict_types=1);

namespace App\Modules\Product\Request;

use Illuminate\Foundation\Http\FormRequest;

class TextParameterRequest extends FormRequest
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
            'name' => 'required|unique:products,name,' . $this->id,
            'slug' => 'required|unique:text_parameters,slug,' . $this->id,
            'type_is' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название параметра',
            'name.unique' => 'Название уже существует',
            'slug.required' => 'Введите ссылку параметра',
            'slug.unique' => 'Ссылка уже существует',
        ];
    }
}
