<?php

namespace App\Http\Requests;

use App\Models\CashflowPurchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCashflowPurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cashflow_purchase_edit');
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
            'name' => [
                'string',
                'nullable',
            ],
            'quantity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unit_price' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'discount' => [
                'numeric',
            ],
            'total_price' => [
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
