<?php

namespace App\Http\Requests;

use App\Models\Packing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePackingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('packing_create');
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
            'harvest_codes.*' => [
                'integer',
            ],
            'harvest_codes' => [
                'array',
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
