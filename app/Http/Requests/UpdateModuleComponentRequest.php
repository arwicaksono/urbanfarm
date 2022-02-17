<?php

namespace App\Http\Requests;

use App\Models\ModuleComponent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateModuleComponentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('module_component_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'nullable',
            ],
            'number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
