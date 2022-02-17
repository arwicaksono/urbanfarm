<?php

namespace App\Http\Requests;

use App\Models\PlotCode;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlotCodeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('plot_code_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:plot_codes,id',
        ];
    }
}
