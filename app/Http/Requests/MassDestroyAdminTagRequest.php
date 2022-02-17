<?php

namespace App\Http\Requests;

use App\Models\AdminTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdminTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('admin_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:admin_tags,id',
        ];
    }
}
