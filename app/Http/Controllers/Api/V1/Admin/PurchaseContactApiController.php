<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePurchaseContactRequest;
use App\Http\Requests\UpdatePurchaseContactRequest;
use App\Http\Resources\Admin\PurchaseContactResource;
use App\Models\PurchaseContact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseContactApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('purchase_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseContactResource(PurchaseContact::with(['team'])->get());
    }

    public function store(StorePurchaseContactRequest $request)
    {
        $purchaseContact = PurchaseContact::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $purchaseContact->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PurchaseContactResource($purchaseContact))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PurchaseContact $purchaseContact)
    {
        abort_if(Gate::denies('purchase_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PurchaseContactResource($purchaseContact->load(['team']));
    }

    public function update(UpdatePurchaseContactRequest $request, PurchaseContact $purchaseContact)
    {
        $purchaseContact->update($request->all());

        if (count($purchaseContact->image) > 0) {
            foreach ($purchaseContact->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseContact->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseContact->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PurchaseContactResource($purchaseContact))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PurchaseContact $purchaseContact)
    {
        abort_if(Gate::denies('purchase_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseContact->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
