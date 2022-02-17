<?php

namespace App\Http\Requests;

use App\Models\ModuleActivity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreModuleActivityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('module_activity_create');
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
