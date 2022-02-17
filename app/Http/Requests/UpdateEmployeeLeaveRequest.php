<?php

namespace App\Http\Requests;

use App\Models\EmployeeLeave;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeLeaveRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_leave_edit');
    }

    public function rules()
    {
        return [
            'date_start' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_end' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
