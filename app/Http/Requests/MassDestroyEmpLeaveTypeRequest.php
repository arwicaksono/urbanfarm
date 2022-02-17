<?php

namespace App\Http\Requests;

use App\Models\EmpLeaveType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmpLeaveTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('emp_leave_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:emp_leave_types,id',
        ];
    }
}
