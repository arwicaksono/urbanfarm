<?php

namespace App\Http\Requests;

use App\Models\PurchaseCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePurchaseCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_company_edit');
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
            'phone' => [
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
