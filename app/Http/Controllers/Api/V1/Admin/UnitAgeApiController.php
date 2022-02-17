<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitAgeRequest;
use App\Http\Requests\UpdateUnitAgeRequest;
use App\Http\Resources\Admin\UnitAgeResource;
use App\Models\UnitAge;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitAgeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_age_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitAgeResource(UnitAge::with(['team'])->get());
    }

    public function store(StoreUnitAgeRequest $request)
    {
        $unitAge = UnitAge::create($request->all());

        return (new UnitAgeResource($unitAge))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitAge $unitAge)
    {
        abort_if(Gate::denies('unit_age_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitAgeResource($unitAge->load(['team']));
    }

    public function update(UpdateUnitAgeRequest $request, UnitAge $unitAge)
    {
        $unitAge->update($request->all());

        return (new UnitAgeResource($unitAge))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitAge $unitAge)
    {
        abort_if(Gate::denies('unit_age_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitAge->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
