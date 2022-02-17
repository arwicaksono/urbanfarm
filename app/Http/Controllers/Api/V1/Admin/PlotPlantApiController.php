<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlotPlantRequest;
use App\Http\Requests\UpdatePlotPlantRequest;
use App\Http\Resources\Admin\PlotPlantResource;
use App\Models\PlotPlant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlotPlantApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plot_plant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotPlantResource(PlotPlant::with(['team'])->get());
    }

    public function store(StorePlotPlantRequest $request)
    {
        $plotPlant = PlotPlant::create($request->all());

        return (new PlotPlantResource($plotPlant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PlotPlant $plotPlant)
    {
        abort_if(Gate::denies('plot_plant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotPlantResource($plotPlant->load(['team']));
    }

    public function update(UpdatePlotPlantRequest $request, PlotPlant $plotPlant)
    {
        $plotPlant->update($request->all());

        return (new PlotPlantResource($plotPlant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PlotPlant $plotPlant)
    {
        abort_if(Gate::denies('plot_plant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotPlant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
