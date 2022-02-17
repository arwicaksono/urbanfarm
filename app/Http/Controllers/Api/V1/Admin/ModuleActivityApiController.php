<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleActivityRequest;
use App\Http\Requests\UpdateModuleActivityRequest;
use App\Http\Resources\Admin\ModuleActivityResource;
use App\Models\ModuleActivity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleActivityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('module_activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleActivityResource(ModuleActivity::with(['team'])->get());
    }

    public function store(StoreModuleActivityRequest $request)
    {
        $moduleActivity = ModuleActivity::create($request->all());

        return (new ModuleActivityResource($moduleActivity))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ModuleActivity $moduleActivity)
    {
        abort_if(Gate::denies('module_activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModuleActivityResource($moduleActivity->load(['team']));
    }

    public function update(UpdateModuleActivityRequest $request, ModuleActivity $moduleActivity)
    {
        $moduleActivity->update($request->all());

        return (new ModuleActivityResource($moduleActivity))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ModuleActivity $moduleActivity)
    {
        abort_if(Gate::denies('module_activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleActivity->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
