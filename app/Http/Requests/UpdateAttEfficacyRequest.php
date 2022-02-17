<?php

namespace App\Http\Requests;

use App\Models\AttEfficacy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAttEfficacyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('att_efficacy_edit');
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
