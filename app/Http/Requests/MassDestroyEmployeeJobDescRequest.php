<?php

namespace App\Http\Requests;

use App\Models\EmployeeJobDesc;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmployeeJobDescRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_job_desc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:employee_job_descs,id',
        ];
    }
}
