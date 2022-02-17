<?php

namespace App\Http\Requests;

use App\Models\SalesLabel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalesLabelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sales_label_edit');
    }

    public function rules()
    {
        return [
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
            'price' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'companies.*' => [
                'integer',
            ],
            'companies' => [
                'array',
            ],
        ];
    }
}
