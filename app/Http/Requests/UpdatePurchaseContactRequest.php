<?php

namespace App\Http\Requests;

use App\Models\PurchaseContact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePurchaseContactRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_contact_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'linkedin' => [
                'string',
                'nullable',
            ],
            'twitter' => [
                'string',
                'nullable',
            ],
            'facebook' => [
                'string',
                'nullable',
            ],
            'instagram' => [
                'string',
                'nullable',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
