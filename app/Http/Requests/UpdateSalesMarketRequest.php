<?php

namespace App\Http\Requests;

use App\Models\SalesMarket;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalesMarketRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sales_market_edit');
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
            'website' => [
                'string',
                'nullable',
            ],
            'email' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
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
