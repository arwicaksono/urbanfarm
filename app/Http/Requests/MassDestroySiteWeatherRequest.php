<?php

namespace App\Http\Requests;

use App\Models\SiteWeather;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySiteWeatherRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('site_weather_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:site_weathers,id',
        ];
    }
}
