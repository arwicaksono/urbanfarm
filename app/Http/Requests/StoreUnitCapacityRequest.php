<?php

namespace App\Http\Requests;

use App\Models\UnitCapacity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUnitCapacityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_capacity_create');
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
