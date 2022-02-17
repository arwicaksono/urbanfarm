<?php

namespace App\Http\Requests;

use App\Models\CashflowIncomeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCashflowIncomeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cashflow_income_category_edit');
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
