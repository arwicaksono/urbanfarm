<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreModuleObservationRequest;
use App\Http\Requests\UpdateModuleObservationRequest;
use App\Http\Resources\Admin\ModuleObservationResource;
use App\Models\ModuleObservation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleObservationApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('module_observation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleObservationResource(ModuleObservation::with(['module', 'components', 'tags', 'priority', 'person_in_charge', 'team'])->get());
    }

    public function store(StoreModuleObservationRequest $request)
    {
        $moduleObservation = ModuleObservation::create($request->all());
        $moduleObservation->components()->sync($request->input('components', []));
        $moduleObservation->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $moduleObservation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new ModuleObservationResource($moduleObservation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ModuleObservation $moduleObservation)
    {
        abort_if(Gate::denies('module_observation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleObservationResource($moduleObservation->load(['module', 'components', 'tags', 'priority', 'person_in_charge', 'team']));
    }

    public function update(UpdateModuleObservationRequest $request, ModuleObservation $moduleObservation)
    {
        $moduleObservation->update($request->all());
        $moduleObservation->components()->sync($request->input('components', []));
        $moduleObservation->tags()->sync($request->input('tags', []));
        if (count($moduleObservation->image) > 0) {
            foreach ($moduleObservation->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $moduleObservation->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $moduleObservation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new ModuleObservationResource($moduleObservation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ModuleObservation $moduleObservation)
    {
        abort_if(Gate::denies('module_observation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleObservation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
