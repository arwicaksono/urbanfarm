<?php

namespace App\Http\Requests;

use App\Models\AdminInfo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdminInfoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_info_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'nullable',
            ],
            'start' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
