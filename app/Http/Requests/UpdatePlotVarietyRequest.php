<?php

namespace App\Http\Requests;

use App\Models\PlotVariety;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlotVarietyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_variety_edit');
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
