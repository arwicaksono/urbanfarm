<?php

namespace App\Http\Requests;

use App\Models\AttCategoryComp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAttCategoryCompRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_category_comp_create');
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
