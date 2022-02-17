<?php

namespace App\Http\Requests;

use App\Models\AdminSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_setting_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'subtitle' => [
                'string',
                'nullable',
            ],
            'copyright' => [
                'string',
                'nullable',
            ],
        ];
    }
}
