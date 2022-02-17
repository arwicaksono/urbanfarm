<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCarePackingRequest;
use App\Http\Requests\UpdateCarePackingRequest;
use App\Http\Resources\Admin\CarePackingResource;
use App\Models\CarePacking;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarePackingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_packing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePackingResource(CarePacking::with(['problem_packing', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCarePackingRequest $request)
    {
        $carePacking = CarePacking::create($request->all());
        $carePacking->tags()->sync($request->input('tags', []));
        $carePacking->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $carePacking->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CarePackingResource($carePacking))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CarePacking $carePacking)
    {
        abort_if(Gate::denies('care_packing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePackingResource($carePacking->load(['problem_packing', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCarePackingRequest $request, CarePacking $carePacking)
    {
        $carePacking->update($request->all());
        $carePacking->tags()->sync($request->input('tags', []));
        $carePacking->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($carePacking->image) > 0) {
            foreach ($carePacking->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carePacking->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $carePacking->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CarePackingResource($carePacking))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CarePacking $carePacking)
    {
        abort_if(Gate::denies('care_packing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePacking->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
