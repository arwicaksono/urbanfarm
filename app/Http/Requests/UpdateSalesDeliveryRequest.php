<?php

namespace App\Http\Requests;

use App\Models\SalesDelivery;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalesDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sales_delivery_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'contact' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
