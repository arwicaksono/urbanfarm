<?php

namespace App\Http\Requests;

use App\Models\SalesChannel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalesChannelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sales_channel_edit');
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
