<?php

namespace App\Http\Requests;

use App\Models\SiteInspection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySiteInspectionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('site_inspection_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:site_inspections,id',
        ];
    }
}
