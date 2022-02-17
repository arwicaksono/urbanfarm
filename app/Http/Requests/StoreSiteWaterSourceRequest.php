<?php

namespace App\Http\Requests;

use App\Models\SiteWaterSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSiteWaterSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_water_source_create');
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
