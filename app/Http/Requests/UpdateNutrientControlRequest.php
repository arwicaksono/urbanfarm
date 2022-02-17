<?php

namespace App\Http\Requests;

use App\Models\NutrientControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateNutrientControlRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('nutrient_control_edit');
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
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'ppm' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ph' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'temperature' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
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
