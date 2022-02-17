<?php

namespace App\Http\Requests;

use App\Models\AttTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAttTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_tag_create');
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
