<?php

namespace App\Http\Requests;

use App\Models\SalesCustomer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSalesCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sales_customer_create');
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
            'address' => [
                'string',
                'nullable',
            ],
            'categories.*' => [
                'integer',
            ],
            'categories' => [
                'array',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'email' => [
                'string',
                'nullable',
            ],
            'website' => [
                'string',
                'nullable',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
