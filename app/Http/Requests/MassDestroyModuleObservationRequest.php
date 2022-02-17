<?php

namespace App\Http\Requests;

use App\Models\ModuleObservation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyModuleObservationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('module_observation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:module_observations,id',
        ];
    }
}
