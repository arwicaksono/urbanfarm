<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePurchaseEquipmentRequest;
use App\Http\Requests\UpdatePurchaseEquipmentRequest;
use App\Http\Resources\Admin\PurchaseEquipmentResource;
use App\Models\PurchaseEquipment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseEquipmentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('purchase_equipment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseEquipmentResource(PurchaseEquipment::with(['source', 'category', 'tags', 'statuses', 'team'])->get());
    }

    public function store(StorePurchaseEquipmentRequest $request)
    {
        $purchaseEquipment = PurchaseEquipment::create($request->all());
        $purchaseEquipment->tags()->sync($request->input('tags', []));
        $purchaseEquipment->statuses()->sync($request->input('statuses', []));
        foreach ($request->input('image', []) as $file) {
            $purchaseEquipment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PurchaseEquipmentResource($purchaseEquipment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PurchaseEquipment $purchaseEquipment)
    {
        abort_if(Gate::denies('purchase_equipment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseEquipmentResource($purchaseEquipment->load(['source', 'category', 'tags', 'statuses', 'team']));
    }

    public function update(UpdatePurchaseEquipmentRequest $request, PurchaseEquipment $purchaseEquipment)
    {
        $purchaseEquipment->update($request->all());
        $purchaseEquipment->tags()->sync($request->input('tags', []));
        $purchaseEquipment->statuses()->sync($request->input('statuses', []));
        if (count($purchaseEquipment->image) > 0) {
            foreach ($purchaseEquipment->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseEquipment->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseEquipment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PurchaseEquipmentResource($purchaseEquipment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PurchaseEquipment $purchaseEquipment)
    {
        abort_if(Gate::denies('purchase_equipment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseEquipment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
