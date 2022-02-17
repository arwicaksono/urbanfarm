<?php

namespace App\Http\Requests;

use App\Models\ModuleSystem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreModuleSystemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('module_system_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
