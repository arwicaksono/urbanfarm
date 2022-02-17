<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCashflowPurchaseRequest;
use App\Http\Requests\UpdateCashflowPurchaseRequest;
use App\Http\Resources\Admin\CashflowPurchaseResource;
use App\Models\CashflowPurchase;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashflowPurchaseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cashflow_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowPurchaseResource(CashflowPurchase::with(['is_priority', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCashflowPurchaseRequest $request)
    {
        $cashflowPurchase = CashflowPurchase::create($request->all());
        $cashflowPurchase->tags()->sync($request->input('tags', []));
        $cashflowPurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CashflowPurchaseResource($cashflowPurchase))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CashflowPurchase $cashflowPurchase)
    {
        abort_if(Gate::denies('cashflow_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowPurchaseResource($cashflowPurchase->load(['is_priority', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCashflowPurchaseRequest $request, CashflowPurchase $cashflowPurchase)
    {
        $cashflowPurchase->update($request->all());
        $cashflowPurchase->tags()->sync($request->input('tags', []));
        $cashflowPurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($cashflowPurchase->image) > 0) {
            foreach ($cashflowPurchase->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowPurchase->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CashflowPurchaseResource($cashflowPurchase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CashflowPurchase $cashflowPurchase)
    {
        abort_if(Gate::denies('cashflow_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowPurchase->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
