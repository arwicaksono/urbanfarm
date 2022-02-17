<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitQuantityRequest;
use App\Http\Requests\UpdateUnitQuantityRequest;
use App\Http\Resources\Admin\UnitQuantityResource;
use App\Models\UnitQuantity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitQuantityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_quantity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitQuantityResource(UnitQuantity::with(['team'])->get());
    }

    public function store(StoreUnitQuantityRequest $request)
    {
        $unitQuantity = UnitQuantity::create($request->all());

        return (new UnitQuantityResource($unitQuantity))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitQuantity $unitQuantity)
    {
        abort_if(Gate::denies('unit_quantity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitQuantityResource($unitQuantity->load(['team']));
    }

    public function update(UpdateUnitQuantityRequest $request, UnitQuantity $unitQuantity)
    {
        $unitQuantity->update($request->all());

        return (new UnitQuantityResource($unitQuantity))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitQuantity $unitQuantity)
    {
        abort_if(Gate::denies('unit_quantity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitQuantity->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
