<?php

namespace App\Http\Requests;

use App\Models\EmployeeAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_attendance_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'arrival' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'departure' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
