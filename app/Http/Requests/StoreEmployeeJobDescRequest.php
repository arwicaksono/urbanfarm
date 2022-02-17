<?php

namespace App\Http\Requests;

use App\Models\EmployeeJobDesc;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeJobDescRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_job_desc_create');
    }

    public function rules()
    {
        return [];
    }
}
