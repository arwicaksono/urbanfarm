<?php

namespace App\Http\Requests;

use App\Models\UnitArea;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUnitAreaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_area_edit');
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
