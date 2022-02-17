<?php

namespace App\Http\Requests;

use App\Models\PlantAssessment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePlantAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plant_assessment_create');
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
            'age' => [
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
