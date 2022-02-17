<?php

namespace App\Http\Requests;

use App\Models\Plot;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlotRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plot_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'nullable',
            ],
            'number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'plot_qty' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'date_start' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_start' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'date_end' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_end' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
