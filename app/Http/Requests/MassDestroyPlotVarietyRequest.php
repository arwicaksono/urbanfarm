<?php

namespace App\Http\Requests;

use App\Models\PlotVariety;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlotVarietyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('plot_variety_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:plot_varieties,id',
        ];
    }
}
