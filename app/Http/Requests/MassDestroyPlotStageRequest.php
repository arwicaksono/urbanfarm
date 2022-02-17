<?php

namespace App\Http\Requests;

use App\Models\PlotStage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlotStageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('plot_stage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:plot_stages,id',
        ];
    }
}
