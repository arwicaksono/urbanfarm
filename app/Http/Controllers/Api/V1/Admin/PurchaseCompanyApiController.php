<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePurchaseCompanyRequest;
use App\Http\Requests\UpdatePurchaseCompanyRequest;
use App\Http\Resources\Admin\PurchaseCompanyResource;
use App\Models\PurchaseCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseCompanyApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('purchase_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseCompanyResource(PurchaseCompany::with(['contact_person', 'category', 'team'])->get());
    }

    public function store(StorePurchaseCompanyRequest $request)
    {
        $purchaseCompany = PurchaseCompany::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $purchaseCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PurchaseCompanyResource($purchaseCompany))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PurchaseCompany $purchaseCompany)
    {
        abort_if(Gate::denies('purchase_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseCompanyResource($purchaseCompany->load(['contact_person', 'category', 'team']));
    }

    public function update(UpdatePurchaseCompanyRequest $request, PurchaseCompany $purchaseCompany)
    {
        $purchaseCompany->update($request->all());

        if (count($purchaseCompany->image) > 0) {
            foreach ($purchaseCompany->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseCompany->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PurchaseCompanyResource($purchaseCompany))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PurchaseCompany $purchaseCompany)
    {
        abort_if(Gate::denies('purchase_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseCompany->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
