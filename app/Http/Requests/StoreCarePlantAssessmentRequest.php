<?php

namespace App\Http\Requests;

use App\Models\CarePlantAssessment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCarePlantAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('care_plant_assessment_create');
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
            'action' => [
                'string',
                'nullable',
            ],
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_start' => [
                'date_format:' . config('panel.time_format'),
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
            'person_in_charges.*' => [
                'integer',
            ],
            'person_in_charges' => [
                'array',
            ],
        ];
    }
}
