<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleSystemRequest;
use App\Http\Requests\UpdateModuleSystemRequest;
use App\Http\Resources\Admin\ModuleSystemResource;
use App\Models\ModuleSystem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleSystemApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('module_system_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleSystemResource(ModuleSystem::with(['team'])->get());
    }

    public function store(StoreModuleSystemRequest $request)
    {
        $moduleSystem = ModuleSystem::create($request->all());

        return (new ModuleSystemResource($moduleSystem))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ModuleSystem $moduleSystem)
    {
        abort_if(Gate::denies('module_system_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleSystemResource($moduleSystem->load(['team']));
    }

    public function update(UpdateModuleSystemRequest $request, ModuleSystem $moduleSystem)
    {
        $moduleSystem->update($request->all());

        return (new ModuleSystemResource($moduleSystem))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ModuleSystem $moduleSystem)
    {
        abort_if(Gate::denies('module_system_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleSystem->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
