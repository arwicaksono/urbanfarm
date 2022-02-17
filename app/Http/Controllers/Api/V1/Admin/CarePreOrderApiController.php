<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCarePreOrderRequest;
use App\Http\Requests\UpdateCarePreOrderRequest;
use App\Http\Resources\Admin\CarePreOrderResource;
use App\Models\CarePreOrder;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarePreOrderApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_pre_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePreOrderResource(CarePreOrder::with(['customer', 'product', 'unit', 'tags', 'priority', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCarePreOrderRequest $request)
    {
        $carePreOrder = CarePreOrder::create($request->all());
        $carePreOrder->tags()->sync($request->input('tags', []));
        $carePreOrder->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $carePreOrder->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CarePreOrderResource($carePreOrder))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CarePreOrder $carePreOrder)
    {
        abort_if(Gate::denies('care_pre_order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePreOrderResource($carePreOrder->load(['customer', 'product', 'unit', 'tags', 'priority', 'person_in_charges', 'team']));
    }

    public function update(UpdateCarePreOrderRequest $request, CarePreOrder $carePreOrder)
    {
        $carePreOrder->update($request->all());
        $carePreOrder->tags()->sync($request->input('tags', []));
        $carePreOrder->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($carePreOrder->image) > 0) {
            foreach ($carePreOrder->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carePreOrder->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $carePreOrder->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CarePreOrderResource($carePreOrder))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CarePreOrder $carePreOrder)
    {
        abort_if(Gate::denies('care_pre_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePreOrder->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
