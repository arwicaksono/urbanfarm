<?php

namespace App\Http\Requests;

use App\Models\PurchaseSubstance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePurchaseSubstanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_substance_edit');
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
            'brands.*' => [
                'integer',
            ],
            'brands' => [
                'array',
            ],
            'quantity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
