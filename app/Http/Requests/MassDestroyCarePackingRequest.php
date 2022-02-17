<?php

namespace App\Http\Requests;

use App\Models\CarePacking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCarePackingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('care_packing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:care_packings,id',
        ];
    }
}
