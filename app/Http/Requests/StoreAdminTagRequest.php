<?php

namespace App\Http\Requests;

use App\Models\AdminTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdminTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_tag_create');
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
