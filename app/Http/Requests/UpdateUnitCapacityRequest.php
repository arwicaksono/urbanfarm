<?php

namespace App\Http\Requests;

use App\Models\UnitCapacity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitCapacityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_capacity_edit');
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
