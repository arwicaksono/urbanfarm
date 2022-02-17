<?php

namespace App\Http\Requests;

use App\Models\UnitQuantity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUnitQuantityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_quantity_create');
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
