<?php

namespace App\Http\Requests;

use App\Models\CareSale;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCareSaleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('care_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:care_sales,id',
        ];
    }
}
