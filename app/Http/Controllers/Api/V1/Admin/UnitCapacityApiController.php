<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitCapacityRequest;
use App\Http\Requests\UpdateUnitCapacityRequest;
use App\Http\Resources\Admin\UnitCapacityResource;
use App\Models\UnitCapacity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitCapacityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_capacity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitCapacityResource(UnitCapacity::with(['team'])->get());
    }

    public function store(StoreUnitCapacityRequest $request)
    {
        $unitCapacity = UnitCapacity::create($request->all());

        return (new UnitCapacityResource($unitCapacity))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitCapacity $unitCapacity)
    {
        abort_if(Gate::denies('unit_capacity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitCapacityResource($unitCapacity->load(['team']));
    }

    public function update(UpdateUnitCapacityRequest $request, UnitCapacity $unitCapacity)
    {
        $unitCapacity->update($request->all());

        return (new UnitCapacityResource($unitCapacity))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitCapacity $unitCapacity)
    {
        abort_if(Gate::denies('unit_capacity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitCapacity->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
