<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCashflowExpenseRequest;
use App\Http\Requests\UpdateCashflowExpenseRequest;
use App\Http\Resources\Admin\CashflowExpenseResource;
use App\Models\CashflowExpense;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashflowExpenseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cashflow_expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowExpenseResource(CashflowExpense::with(['category', 'tags', 'team'])->get());
    }

    public function store(StoreCashflowExpenseRequest $request)
    {
        $cashflowExpense = CashflowExpense::create($request->all());
        $cashflowExpense->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowExpense->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CashflowExpenseResource($cashflowExpense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CashflowExpense $cashflowExpense)
    {
        abort_if(Gate::denies('cashflow_expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowExpenseResource($cashflowExpense->load(['category', 'tags', 'team']));
    }

    public function update(UpdateCashflowExpenseRequest $request, CashflowExpense $cashflowExpense)
    {
        $cashflowExpense->update($request->all());
        $cashflowExpense->tags()->sync($request->input('tags', []));
        if (count($cashflowExpense->image) > 0) {
            foreach ($cashflowExpense->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowExpense->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowExpense->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CashflowExpenseResource($cashflowExpense))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CashflowExpense $cashflowExpense)
    {
        abort_if(Gate::denies('cashflow_expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpense->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
