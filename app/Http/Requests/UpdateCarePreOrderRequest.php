<?php

namespace App\Http\Requests;

use App\Models\CarePreOrder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarePreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('care_pre_order_edit');
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
            'qty' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'date_due' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_due' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'date_delivery' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_delivery' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
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
