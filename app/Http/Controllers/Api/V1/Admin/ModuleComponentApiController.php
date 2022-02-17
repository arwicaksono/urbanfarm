<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreModuleComponentRequest;
use App\Http\Requests\UpdateModuleComponentRequest;
use App\Http\Resources\Admin\ModuleComponentResource;
use App\Models\ModuleComponent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleComponentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('module_component_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleComponentResource(ModuleComponent::with(['brand', 'company', 'category', 'team'])->get());
    }

    public function store(StoreModuleComponentRequest $request)
    {
        $moduleComponent = ModuleComponent::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $moduleComponent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new ModuleComponentResource($moduleComponent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ModuleComponent $moduleComponent)
    {
        abort_if(Gate::denies('module_component_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleComponentResource($moduleComponent->load(['brand', 'company', 'category', 'team']));
    }

    public function update(UpdateModuleComponentRequest $request, ModuleComponent $moduleComponent)
    {
        $moduleComponent->update($request->all());

        if (count($moduleComponent->image) > 0) {
            foreach ($moduleComponent->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $moduleComponent->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $moduleComponent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new ModuleComponentResource($moduleComponent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ModuleComponent $moduleComponent)
    {
        abort_if(Gate::denies('module_component_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleComponent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
