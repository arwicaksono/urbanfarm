<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlotStageRequest;
use App\Http\Requests\UpdatePlotStageRequest;
use App\Http\Resources\Admin\PlotStageResource;
use App\Models\PlotStage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlotStageApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plot_stage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotStageResource(PlotStage::with(['team'])->get());
    }

    public function store(StorePlotStageRequest $request)
    {
        $plotStage = PlotStage::create($request->all());

        return (new PlotStageResource($plotStage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PlotStage $plotStage)
    {
        abort_if(Gate::denies('plot_stage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotStageResource($plotStage->load(['team']));
    }

    public function update(UpdatePlotStageRequest $request, PlotStage $plotStage)
    {
        $plotStage->update($request->all());

        return (new PlotStageResource($plotStage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PlotStage $plotStage)
    {
        abort_if(Gate::denies('plot_stage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotStage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
