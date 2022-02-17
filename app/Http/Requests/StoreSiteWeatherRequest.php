<?php

namespace App\Http\Requests;

use App\Models\SiteWeather;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSiteWeatherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_weather_create');
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
