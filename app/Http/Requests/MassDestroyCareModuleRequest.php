<?php

namespace App\Http\Requests;

use App\Models\CareModule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCareModuleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('care_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:care_modules,id',
        ];
    }
}
