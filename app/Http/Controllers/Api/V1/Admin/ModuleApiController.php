<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Http\Resources\Admin\ModuleResource;
use App\Models\Module;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleResource(Module::with(['site_code', 'system', 'lighting', 'reservoir', 'pump', 'mounting', 'unit', 'acitivities', 'team'])->get());
    }

    public function store(StoreModuleRequest $request)
    {
        $module = Module::create($request->all());
        $module->acitivities()->sync($request->input('acitivities', []));
        foreach ($request->input('image', []) as $file) {
            $module->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new ModuleResource($module))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Module $module)
    {
        abort_if(Gate::denies('module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleResource($module->load(['site_code', 'system', 'lighting', 'reservoir', 'pump', 'mounting', 'unit', 'acitivities', 'team']));
    }

    public function update(UpdateModuleRequest $request, Module $module)
    {
        $module->update($request->all());
        $module->acitivities()->sync($request->input('acitivities', []));
        if (count($module->image) > 0) {
            foreach ($module->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $module->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $module->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new ModuleResource($module))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Module $module)
    {
        abort_if(Gate::denies('module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $module->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
