<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitAreaRequest;
use App\Http\Requests\UpdateUnitAreaRequest;
use App\Http\Resources\Admin\UnitAreaResource;
use App\Models\UnitArea;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitAreaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitAreaResource(UnitArea::with(['team'])->get());
    }

    public function store(StoreUnitAreaRequest $request)
    {
        $unitArea = UnitArea::create($request->all());

        return (new UnitAreaResource($unitArea))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitArea $unitArea)
    {
        abort_if(Gate::denies('unit_area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitAreaResource($unitArea->load(['team']));
    }

    public function update(UpdateUnitAreaRequest $request, UnitArea $unitArea)
    {
        $unitArea->update($request->all());

        return (new UnitAreaResource($unitArea))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitArea $unitArea)
    {
        abort_if(Gate::denies('unit_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitArea->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
