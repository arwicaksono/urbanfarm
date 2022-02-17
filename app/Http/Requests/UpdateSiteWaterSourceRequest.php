<?php

namespace App\Http\Requests;

use App\Models\SiteWaterSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSiteWaterSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_water_source_edit');
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
