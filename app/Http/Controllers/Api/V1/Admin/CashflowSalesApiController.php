<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCashflowSaleRequest;
use App\Http\Requests\UpdateCashflowSaleRequest;
use App\Http\Resources\Admin\CashflowSaleResource;
use App\Models\CashflowSale;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashflowSalesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cashflow_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowSaleResource(CashflowSale::with(['packing_code', 'unit', 'tags', 'is_priority', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCashflowSaleRequest $request)
    {
        $cashflowSale = CashflowSale::create($request->all());
        $cashflowSale->tags()->sync($request->input('tags', []));
        $cashflowSale->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CashflowSaleResource($cashflowSale))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CashflowSale $cashflowSale)
    {
        abort_if(Gate::denies('cashflow_sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CashflowSaleResource($cashflowSale->load(['packing_code', 'unit', 'tags', 'is_priority', 'person_in_charges', 'team']));
    }

    public function update(UpdateCashflowSaleRequest $request, CashflowSale $cashflowSale)
    {
        $cashflowSale->update($request->all());
        $cashflowSale->tags()->sync($request->input('tags', []));
        $cashflowSale->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($cashflowSale->image) > 0) {
            foreach ($cashflowSale->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowSale->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CashflowSaleResource($cashflowSale))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CashflowSale $cashflowSale)
    {
        abort_if(Gate::denies('cashflow_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowSale->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
