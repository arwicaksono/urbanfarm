<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashflowExpenseCategoryRequest;
use App\Http\Requests\UpdateCashflowExpenseCategoryRequest;
use App\Http\Resources\Admin\CashflowExpenseCategoryResource;
use App\Models\CashflowExpenseCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashflowExpenseCategoriesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cashflow_expense_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowExpenseCategoryResource(CashflowExpenseCategory::with(['team'])->get());
    }

    public function store(StoreCashflowExpenseCategoryRequest $request)
    {
        $cashflowExpenseCategory = CashflowExpenseCategory::create($request->all());

        return (new CashflowExpenseCategoryResource($cashflowExpenseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CashflowExpenseCategory $cashflowExpenseCategory)
    {
        abort_if(Gate::denies('cashflow_expense_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowExpenseCategoryResource($cashflowExpenseCategory->load(['team']));
    }

    public function update(UpdateCashflowExpenseCategoryRequest $request, CashflowExpenseCategory $cashflowExpenseCategory)
    {
        $cashflowExpenseCategory->update($request->all());

        return (new CashflowExpenseCategoryResource($cashflowExpenseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CashflowExpenseCategory $cashflowExpenseCategory)
    {
        abort_if(Gate::denies('cashflow_expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpenseCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
