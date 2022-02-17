<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlotVarietyRequest;
use App\Http\Requests\UpdatePlotVarietyRequest;
use App\Http\Resources\Admin\PlotVarietyResource;
use App\Models\PlotVariety;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlotVarietyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plot_variety_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotVarietyResource(PlotVariety::with(['brand', 'team'])->get());
    }

    public function store(StorePlotVarietyRequest $request)
    {
        $plotVariety = PlotVariety::create($request->all());

        return (new PlotVarietyResource($plotVariety))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PlotVariety $plotVariety)
    {
        abort_if(Gate::denies('plot_variety_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotVarietyResource($plotVariety->load(['brand', 'team']));
    }

    public function update(UpdatePlotVarietyRequest $request, PlotVariety $plotVariety)
    {
        $plotVariety->update($request->all());

        return (new PlotVarietyResource($plotVariety))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PlotVariety $plotVariety)
    {
        abort_if(Gate::denies('plot_variety_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotVariety->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
