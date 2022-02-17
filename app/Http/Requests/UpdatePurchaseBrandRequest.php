<?php

namespace App\Http\Requests;

use App\Models\PurchaseBrand;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePurchaseBrandRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_brand_edit');
    }

    public function rules()
    {
        return [
            'name' => [
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
