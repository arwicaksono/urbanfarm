<?php

namespace App\Http\Requests;

use App\Models\EmployeeAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmployeeAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:employee_attendances,id',
        ];
    }
}
