<?php

namespace App\Http\Requests;

use App\Models\EmployeeStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_status_edit');
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
