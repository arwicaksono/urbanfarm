<?php

namespace App\Http\Requests;

use App\Models\PlotStage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlotStageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_stage_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'period' => [
                'string',
                'nullable',
            ],
        ];
    }
}
