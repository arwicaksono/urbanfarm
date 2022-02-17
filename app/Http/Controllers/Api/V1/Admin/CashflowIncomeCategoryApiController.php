<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashflowIncomeCategoryRequest;
use App\Http\Requests\UpdateCashflowIncomeCategoryRequest;
use App\Http\Resources\Admin\CashflowIncomeCategoryResource;
use App\Models\CashflowIncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashflowIncomeCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cashflow_income_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowIncomeCategoryResource(CashflowIncomeCategory::with(['team'])->get());
    }

    public function store(StoreCashflowIncomeCategoryRequest $request)
    {
        $cashflowIncomeCategory = CashflowIncomeCategory::create($request->all());

        return (new CashflowIncomeCategoryResource($cashflowIncomeCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CashflowIncomeCategory $cashflowIncomeCategory)
    {
        abort_if(Gate::denies('cashflow_income_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowIncomeCategoryResource($cashflowIncomeCategory->load(['team']));
    }

    public function update(UpdateCashflowIncomeCategoryRequest $request, CashflowIncomeCategory $cashflowIncomeCategory)
    {
        $cashflowIncomeCategory->update($request->all());

        return (new CashflowIncomeCategoryResource($cashflowIncomeCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CashflowIncomeCategory $cashflowIncomeCategory)
    {
        abort_if(Gate::denies('cashflow_income_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncomeCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
