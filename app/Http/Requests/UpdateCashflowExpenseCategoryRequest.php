<?php

namespace App\Http\Requests;

use App\Models\CashflowExpenseCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCashflowExpenseCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cashflow_expense_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
