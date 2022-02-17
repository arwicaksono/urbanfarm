<?php

namespace App\Http\Requests;

use App\Models\AdminCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdminCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_category_create');
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
