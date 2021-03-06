<?php

namespace App\Http\Requests;

use App\Models\SiteSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_setting_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
