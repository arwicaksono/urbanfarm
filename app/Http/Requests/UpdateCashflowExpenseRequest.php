<?php

namespace App\Http\Requests;

use App\Models\CashflowExpense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCashflowExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cashflow_expense_edit');
    }

    public function rules()
    {
        return [
            'amount' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'image' => [
                'array',
            ],
        ];
    }
}
