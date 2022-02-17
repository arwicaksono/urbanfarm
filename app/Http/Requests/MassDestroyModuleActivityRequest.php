<?php

namespace App\Http\Requests;

use App\Models\ModuleActivity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyModuleActivityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('module_activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:module_activities,id',
        ];
    }
}
