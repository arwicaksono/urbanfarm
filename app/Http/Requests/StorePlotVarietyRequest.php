<?php

namespace App\Http\Requests;

use App\Models\PlotVariety;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePlotVarietyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_variety_create');
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
