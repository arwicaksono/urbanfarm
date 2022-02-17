<?php

namespace App\Http\Requests;

use App\Models\BusinessSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBusinessSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('business_setting_create');
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
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'whatsapp' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'telegram' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'facebook' => [
                'string',
                'nullable',
            ],
            'twitter' => [
                'string',
                'nullable',
            ],
            'instagram' => [
                'string',
                'nullable',
            ],
            'linked_in' => [
                'string',
                'nullable',
            ],
            'youtube' => [
                'string',
                'nullable',
            ],
            'pinterest' => [
                'string',
                'nullable',
            ],
            'reddit' => [
                'string',
                'nullable',
            ],
            'website' => [
                'string',
                'nullable',
            ],
        ];
    }
}
