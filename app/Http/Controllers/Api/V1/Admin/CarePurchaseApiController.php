<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCarePurchaseRequest;
use App\Http\Requests\UpdateCarePurchaseRequest;
use App\Http\Resources\Admin\CarePurchaseResource;
use App\Models\CarePurchase;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarePurchaseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePurchaseResource(CarePurchase::with(['problem_purchase', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCarePurchaseRequest $request)
    {
        $carePurchase = CarePurchase::create($request->all());
        $carePurchase->tags()->sync($request->input('tags', []));
        $carePurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $carePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CarePurchaseResource($carePurchase))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CarePurchase $carePurchase)
    {
        abort_if(Gate::denies('care_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePurchaseResource($carePurchase->load(['problem_purchase', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCarePurchaseRequest $request, CarePurchase $carePurchase)
    {
        $carePurchase->update($request->all());
        $carePurchase->tags()->sync($request->input('tags', []));
        $carePurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($carePurchase->image) > 0) {
            foreach ($carePurchase->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carePurchase->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $carePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CarePurchaseResource($carePurchase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CarePurchase $carePurchase)
    {
        abort_if(Gate::denies('care_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePurchase->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
