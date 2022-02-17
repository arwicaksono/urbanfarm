<?php

namespace App\Http\Requests;

use App\Models\UnitWeight;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitWeightRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_weight_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'metric' => [
                'string',
                'nullable',
            ],
            'imperial' => [
                'string',
                'nullable',
            ],
        ];
    }
}
