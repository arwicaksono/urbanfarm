<?php

namespace App\Http\Requests;

use App\Models\Distribution;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDistributionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('distribution_edit');
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
            'packing_codes.*' => [
                'integer',
            ],
            'packing_codes' => [
                'array',
            ],
            'cost' => [
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
            'person_in_charges.*' => [
                'integer',
            ],
            'person_in_charges' => [
                'array',
            ],
        ];
    }
}
