<?php

namespace App\Http\Requests;

use App\Models\SiteWaterSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySiteWaterSourceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('site_water_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:site_water_sources,id',
        ];
    }
}
