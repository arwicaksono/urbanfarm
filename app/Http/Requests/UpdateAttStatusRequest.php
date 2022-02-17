<?php

namespace App\Http\Requests;

use App\Models\AttStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAttStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_status_edit');
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
