<?php

namespace App\Http\Requests;

use App\Models\PlotPlant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePlotPlantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_plant_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
