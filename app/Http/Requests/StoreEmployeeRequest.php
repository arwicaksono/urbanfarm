<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_create');
    }

    public function rules()
    {
        return [
            'birthdate' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'phone_number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
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
