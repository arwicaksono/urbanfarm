<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitWeightRequest;
use App\Http\Requests\UpdateUnitWeightRequest;
use App\Http\Resources\Admin\UnitWeightResource;
use App\Models\UnitWeight;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitWeightApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_weight_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitWeightResource(UnitWeight::with(['team'])->get());
    }

    public function store(StoreUnitWeightRequest $request)
    {
        $unitWeight = UnitWeight::create($request->all());

        return (new UnitWeightResource($unitWeight))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitWeight $unitWeight)
    {
        abort_if(Gate::denies('unit_weight_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitWeightResource($unitWeight->load(['team']));
    }

    public function update(UpdateUnitWeightRequest $request, UnitWeight $unitWeight)
    {
        $unitWeight->update($request->all());

        return (new UnitWeightResource($unitWeight))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitWeight $unitWeight)
    {
        abort_if(Gate::denies('unit_weight_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitWeight->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
