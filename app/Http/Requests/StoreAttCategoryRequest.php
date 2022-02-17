<?php

namespace App\Http\Requests;

use App\Models\AttCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAttCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'group' => [
                'string',
                'nullable',
            ],
        ];
    }
}
