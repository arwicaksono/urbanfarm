<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCareHarvestRequest;
use App\Http\Requests\UpdateCareHarvestRequest;
use App\Http\Resources\Admin\CareHarvestResource;
use App\Models\CareHarvest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareHarvestApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_harvest_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareHarvestResource(CareHarvest::with(['problem_harvest', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCareHarvestRequest $request)
    {
        $careHarvest = CareHarvest::create($request->all());
        $careHarvest->tags()->sync($request->input('tags', []));
        $careHarvest->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $careHarvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CareHarvestResource($careHarvest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CareHarvest $careHarvest)
    {
        abort_if(Gate::denies('care_harvest_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareHarvestResource($careHarvest->load(['problem_harvest', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCareHarvestRequest $request, CareHarvest $careHarvest)
    {
        $careHarvest->update($request->all());
        $careHarvest->tags()->sync($request->input('tags', []));
        $careHarvest->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($careHarvest->image) > 0) {
            foreach ($careHarvest->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $careHarvest->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $careHarvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CareHarvestResource($careHarvest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CareHarvest $careHarvest)
    {
        abort_if(Gate::denies('care_harvest_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careHarvest->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
