<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePurchaseSubstanceRequest;
use App\Http\Requests\UpdatePurchaseSubstanceRequest;
use App\Http\Resources\Admin\PurchaseSubstanceResource;
use App\Models\PurchaseSubstance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseSubstanceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('purchase_substance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseSubstanceResource(PurchaseSubstance::with(['categories', 'tags', 'brands', 'unit', 'team'])->get());
    }

    public function store(StorePurchaseSubstanceRequest $request)
    {
        $purchaseSubstance = PurchaseSubstance::create($request->all());
        $purchaseSubstance->categories()->sync($request->input('categories', []));
        $purchaseSubstance->tags()->sync($request->input('tags', []));
        $purchaseSubstance->brands()->sync($request->input('brands', []));
        foreach ($request->input('image', []) as $file) {
            $purchaseSubstance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PurchaseSubstanceResource($purchaseSubstance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PurchaseSubstance $purchaseSubstance)
    {
        abort_if(Gate::denies('purchase_substance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseSubstanceResource($purchaseSubstance->load(['categories', 'tags', 'brands', 'unit', 'team']));
    }

    public function update(UpdatePurchaseSubstanceRequest $request, PurchaseSubstance $purchaseSubstance)
    {
        $purchaseSubstance->update($request->all());
        $purchaseSubstance->categories()->sync($request->input('categories', []));
        $purchaseSubstance->tags()->sync($request->input('tags', []));
        $purchaseSubstance->brands()->sync($request->input('brands', []));
        if (count($purchaseSubstance->image) > 0) {
            foreach ($purchaseSubstance->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseSubstance->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseSubstance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PurchaseSubstanceResource($purchaseSubstance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PurchaseSubstance $purchaseSubstance)
    {
        abort_if(Gate::denies('purchase_substance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseSubstance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
