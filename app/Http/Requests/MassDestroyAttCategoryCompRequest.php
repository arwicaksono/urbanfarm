<?php

namespace App\Http\Requests;

use App\Models\AttCategoryComp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAttCategoryCompRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('att_category_comp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:att_category_comps,id',
        ];
    }
}
