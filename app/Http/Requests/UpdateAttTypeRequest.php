<?php

namespace App\Http\Requests;

use App\Models\AttType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAttTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_type_edit');
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
