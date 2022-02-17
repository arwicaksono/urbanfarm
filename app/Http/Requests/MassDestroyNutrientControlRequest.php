<?php

namespace App\Http\Requests;

use App\Models\NutrientControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyNutrientControlRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('nutrient_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:nutrient_controls,id',
        ];
    }
}
