<?php

namespace App\Http\Requests;

use App\Models\AdminExpert;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdminExpertRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('admin_expert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:admin_experts,id',
        ];
    }
}
