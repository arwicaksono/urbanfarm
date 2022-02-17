<?php

namespace App\Http\Requests;

use App\Models\AdminExpert;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminExpertRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_expert_edit');
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
