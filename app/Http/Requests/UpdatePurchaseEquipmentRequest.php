<?php

namespace App\Http\Requests;

use App\Models\PurchaseEquipment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePurchaseEquipmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_equipment_edit');
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
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'statuses.*' => [
                'integer',
            ],
            'statuses' => [
                'array',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
