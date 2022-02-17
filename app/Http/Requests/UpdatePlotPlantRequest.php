<?php

namespace App\Http\Requests;

use App\Models\PlotPlant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlotPlantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_plant_edit');
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
