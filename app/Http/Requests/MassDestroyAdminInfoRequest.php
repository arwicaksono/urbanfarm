<?php

namespace App\Http\Requests;

use App\Models\AdminInfo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdminInfoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('admin_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:admin_infos,id',
        ];
    }
}
