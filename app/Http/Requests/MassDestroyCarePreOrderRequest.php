<?php

namespace App\Http\Requests;

use App\Models\CarePreOrder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCarePreOrderRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('care_pre_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:care_pre_orders,id',
        ];
    }
}
