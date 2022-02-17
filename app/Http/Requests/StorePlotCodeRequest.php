<?php

namespace App\Http\Requests;

use App\Models\PlotCode;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePlotCodeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_code_create');
    }

    public function rules()
    {
        return [
            'prefix' => [
                'string',
                'nullable',
            ],
            'plant' => [
                'string',
                'nullable',
            ],
        ];
    }
}
