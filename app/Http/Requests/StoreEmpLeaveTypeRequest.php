<?php

namespace App\Http\Requests;

use App\Models\EmpLeaveType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmpLeaveTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('emp_leave_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
