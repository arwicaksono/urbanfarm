<?php

namespace App\Http\Requests;

use App\Models\UnitAge;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitAgeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_age_edit');
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
