<?php

namespace App\Http\Requests;

use App\Models\AttPriority;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAttPriorityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_priority_edit');
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
