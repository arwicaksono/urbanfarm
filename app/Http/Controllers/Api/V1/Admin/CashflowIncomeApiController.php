<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCashflowIncomeRequest;
use App\Http\Requests\UpdateCashflowIncomeRequest;
use App\Http\Resources\Admin\CashflowIncomeResource;
use App\Models\CashflowIncome;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashflowIncomeApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cashflow_income_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowIncomeResource(CashflowIncome::with(['category', 'tags', 'team'])->get());
    }

    public function store(StoreCashflowIncomeRequest $request)
    {
        $cashflowIncome = CashflowIncome::create($request->all());
        $cashflowIncome->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowIncome->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CashflowIncomeResource($cashflowIncome))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CashflowIncome $cashflowIncome)
    {
        abort_if(Gate::denies('cashflow_income_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowIncomeResource($cashflowIncome->load(['category', 'tags', 'team']));
    }

    public function update(UpdateCashflowIncomeRequest $request, CashflowIncome $cashflowIncome)
    {
        $cashflowIncome->update($request->all());
        $cashflowIncome->tags()->sync($request->input('tags', []));
        if (count($cashflowIncome->image) > 0) {
            foreach ($cashflowIncome->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowIncome->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowIncome->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CashflowIncomeResource($cashflowIncome))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CashflowIncome $cashflowIncome)
    {
        abort_if(Gate::denies('cashflow_income_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncome->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
