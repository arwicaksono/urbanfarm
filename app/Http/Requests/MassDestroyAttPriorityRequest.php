<?php

namespace App\Http\Requests;

use App\Models\AttPriority;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAttPriorityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('att_priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:att_priorities,id',
        ];
    }
}
