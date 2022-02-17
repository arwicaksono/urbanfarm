<?php

namespace App\Http\Requests;

use App\Models\AdminCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_category_edit');
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
