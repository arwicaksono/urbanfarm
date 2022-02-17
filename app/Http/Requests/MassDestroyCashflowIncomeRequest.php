<?php

namespace App\Http\Requests;

use App\Models\CashflowIncome;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCashflowIncomeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cashflow_income_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cashflow_incomes,id',
        ];
    }
}
