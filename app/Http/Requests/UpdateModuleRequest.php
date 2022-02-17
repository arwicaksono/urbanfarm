<?php

namespace App\Http\Requests;

use App\Models\Module;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateModuleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('module_edit');
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
            'capacity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'acitivities.*' => [
                'integer',
            ],
            'acitivities' => [
                'array',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
