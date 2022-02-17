<?php

namespace App\Http\Requests;

use App\Models\SalesPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalesPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sales_payment_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
