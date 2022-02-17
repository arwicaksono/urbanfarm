<?php

namespace App\Http\Requests;

use App\Models\EmployeeLeave;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmployeeLeaveRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:employee_leaves,id',
        ];
    }
}
