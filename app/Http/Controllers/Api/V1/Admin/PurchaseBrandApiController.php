<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePurchaseBrandRequest;
use App\Http\Requests\UpdatePurchaseBrandRequest;
use App\Http\Resources\Admin\PurchaseBrandResource;
use App\Models\PurchaseBrand;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseBrandApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('purchase_brand_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseBrandResource(PurchaseBrand::with(['company', 'category', 'tags', 'team'])->get());
    }

    public function store(StorePurchaseBrandRequest $request)
    {
        $purchaseBrand = PurchaseBrand::create($request->all());
        $purchaseBrand->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $purchaseBrand->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PurchaseBrandResource($purchaseBrand))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PurchaseBrand $purchaseBrand)
    {
        abort_if(Gate::denies('purchase_brand_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseBrandResource($purchaseBrand->load(['company', 'category', 'tags', 'team']));
    }

    public function update(UpdatePurchaseBrandRequest $request, PurchaseBrand $purchaseBrand)
    {
        $purchaseBrand->update($request->all());
        $purchaseBrand->tags()->sync($request->input('tags', []));
        if (count($purchaseBrand->image) > 0) {
            foreach ($purchaseBrand->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseBrand->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseBrand->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PurchaseBrandResource($purchaseBrand))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PurchaseBrand $purchaseBrand)
    {
        abort_if(Gate::denies('purchase_brand_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseBrand->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
