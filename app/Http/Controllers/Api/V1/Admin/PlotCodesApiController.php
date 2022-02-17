<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlotCodeRequest;
use App\Http\Requests\UpdatePlotCodeRequest;
use App\Http\Resources\Admin\PlotCodeResource;
use App\Models\PlotCode;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlotCodesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plot_code_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotCodeResource(PlotCode::with(['team'])->get());
    }

    public function store(StorePlotCodeRequest $request)
    {
        $plotCode = PlotCode::create($request->all());

        return (new PlotCodeResource($plotCode))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PlotCode $plotCode)
    {
        abort_if(Gate::denies('plot_code_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotCodeResource($plotCode->load(['team']));
    }

    public function update(UpdatePlotCodeRequest $request, PlotCode $plotCode)
    {
        $plotCode->update($request->all());

        return (new PlotCodeResource($plotCode))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PlotCode $plotCode)
    {
        abort_if(Gate::denies('plot_code_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotCode->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
