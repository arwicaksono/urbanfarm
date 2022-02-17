<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitTemperatureRequest;
use App\Http\Requests\UpdateUnitTemperatureRequest;
use App\Http\Resources\Admin\UnitTemperatureResource;
use App\Models\UnitTemperature;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitTemperatureApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_temperature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitTemperatureResource(UnitTemperature::with(['team'])->get());
    }

    public function store(StoreUnitTemperatureRequest $request)
    {
        $unitTemperature = UnitTemperature::create($request->all());

        return (new UnitTemperatureResource($unitTemperature))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitTemperature $unitTemperature)
    {
        abort_if(Gate::denies('unit_temperature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitTemperatureResource($unitTemperature->load(['team']));
    }

    public function update(UpdateUnitTemperatureRequest $request, UnitTemperature $unitTemperature)
    {
        $unitTemperature->update($request->all());

        return (new UnitTemperatureResource($unitTemperature))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitTemperature $unitTemperature)
    {
        abort_if(Gate::denies('unit_temperature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitTemperature->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
