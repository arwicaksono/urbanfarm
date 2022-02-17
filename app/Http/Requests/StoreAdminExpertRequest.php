<?php

namespace App\Http\Requests;

use App\Models\AdminExpert;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdminExpertRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_expert_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
