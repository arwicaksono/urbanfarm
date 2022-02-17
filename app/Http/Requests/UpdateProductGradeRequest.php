<?php

namespace App\Http\Requests;

use App\Models\ProductGrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProductGradeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_grade_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
