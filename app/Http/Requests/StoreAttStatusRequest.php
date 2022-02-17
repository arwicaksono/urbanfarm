<?php

namespace App\Http\Requests;

use App\Models\AttStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAttStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_status_create');
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
