<?php

namespace App\Http\Requests;

use App\Models\CashflowExpenseCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCashflowExpenseCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cashflow_expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cashflow_expense_categories,id',
        ];
    }
}
