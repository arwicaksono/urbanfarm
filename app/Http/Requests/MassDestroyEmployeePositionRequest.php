<?php

namespace App\Http\Requests;

use App\Models\EmployeePosition;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmployeePositionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_position_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:employee_positions,id',
        ];
    }
}
