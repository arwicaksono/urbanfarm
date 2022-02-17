<?php

namespace App\Http\Requests;

use App\Models\SalesMarket;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySalesMarketRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sales_market_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sales_markets,id',
        ];
    }
}
