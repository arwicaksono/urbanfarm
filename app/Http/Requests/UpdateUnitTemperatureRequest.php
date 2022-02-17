<?php

namespace App\Http\Requests;

use App\Models\UnitTemperature;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitTemperatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_temperature_edit');
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
