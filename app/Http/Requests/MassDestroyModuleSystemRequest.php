<?php

namespace App\Http\Requests;

use App\Models\ModuleSystem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyModuleSystemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('module_system_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:module_systems,id',
        ];
    }
}
