<?php

namespace App\Http\Requests;

use App\Models\Site;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSiteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'nullable',
            ],
            'number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'location' => [
                'string',
                'nullable',
            ],
            'elevation' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'acreage' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'settings.*' => [
                'integer',
            ],
            'settings' => [
                'array',
            ],
            'water_sources.*' => [
                'integer',
            ],
            'water_sources' => [
                'array',
            ],
            'image' => [
                'array',
            ],
            'person_in_charges.*' => [
                'integer',
            ],
            'person_in_charges' => [
                'array',
            ],
        ];
    }
}
