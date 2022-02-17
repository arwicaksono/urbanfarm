<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePlotRequest;
use App\Http\Requests\UpdatePlotRequest;
use App\Http\Resources\Admin\PlotResource;
use App\Models\Plot;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlotApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('plot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotResource(Plot::with(['plot_prefix', 'activity', 'module', 'nutrient_brand', 'unit', 'variety', 'tags', 'team'])->get());
    }

    public function store(StorePlotRequest $request)
    {
        $plot = Plot::create($request->all());
        $plot->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $plot->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PlotResource($plot))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Plot $plot)
    {
        abort_if(Gate::denies('plot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlotResource($plot->load(['plot_prefix', 'activity', 'module', 'nutrient_brand', 'unit', 'variety', 'tags', 'team']));
    }

    public function update(UpdatePlotRequest $request, Plot $plot)
    {
        $plot->update($request->all());
        $plot->tags()->sync($request->input('tags', []));
        if (count($plot->image) > 0) {
            foreach ($plot->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $plot->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $plot->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PlotResource($plot))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Plot $plot)
    {
        abort_if(Gate::denies('plot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plot->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
