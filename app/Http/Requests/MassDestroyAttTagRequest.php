<?php

namespace App\Http\Requests;

use App\Models\AttTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAttTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('att_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:att_tags,id',
        ];
    }
}
