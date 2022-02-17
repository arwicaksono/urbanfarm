<?php

namespace App\Http\Requests;

use App\Models\UnitAge;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUnitAgeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('unit_age_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:unit_ages,id',
        ];
    }
}
