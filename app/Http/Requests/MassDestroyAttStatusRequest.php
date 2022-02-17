<?php

namespace App\Http\Requests;

use App\Models\AttStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAttStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('att_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:att_statuses,id',
        ];
    }
}
