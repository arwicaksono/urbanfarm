<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreHarvestRequest;
use App\Http\Requests\UpdateHarvestRequest;
use App\Http\Resources\Admin\HarvestResource;
use App\Models\Harvest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HarvestApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('harvest_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HarvestResource(Harvest::with(['plot', 'unit', 'grades', 'harvest_unit', 'status', 'tags', 'priority', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreHarvestRequest $request)
    {
        $harvest = Harvest::create($request->all());
        $harvest->grades()->sync($request->input('grades', []));
        $harvest->tags()->sync($request->input('tags', []));
        $harvest->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $harvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new HarvestResource($harvest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Harvest $harvest)
    {
        abort_if(Gate::denies('harvest_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HarvestResource($harvest->load(['plot', 'unit', 'grades', 'harvest_unit', 'status', 'tags', 'priority', 'person_in_charges', 'team']));
    }

    public function update(UpdateHarvestRequest $request, Harvest $harvest)
    {
        $harvest->update($request->all());
        $harvest->grades()->sync($request->input('grades', []));
        $harvest->tags()->sync($request->input('tags', []));
        $harvest->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($harvest->image) > 0) {
            foreach ($harvest->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $harvest->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $harvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new HarvestResource($harvest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Harvest $harvest)
    {
        abort_if(Gate::denies('harvest_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $harvest->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
