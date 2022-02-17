<?php

namespace App\Http\Requests;

use App\Models\EmployeePosition;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeePositionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_position_edit');
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
