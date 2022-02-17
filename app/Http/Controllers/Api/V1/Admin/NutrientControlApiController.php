<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreNutrientControlRequest;
use App\Http\Requests\UpdateNutrientControlRequest;
use App\Http\Resources\Admin\NutrientControlResource;
use App\Models\NutrientControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NutrientControlApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('nutrient_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NutrientControlResource(NutrientControl::with(['module', 'tags', 'priority', 'person_in_charge', 'team'])->get());
    }

    public function store(StoreNutrientControlRequest $request)
    {
        $nutrientControl = NutrientControl::create($request->all());
        $nutrientControl->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $nutrientControl->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new NutrientControlResource($nutrientControl))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(NutrientControl $nutrientControl)
    {
        abort_if(Gate::denies('nutrient_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NutrientControlResource($nutrientControl->load(['module', 'tags', 'priority', 'person_in_charge', 'team']));
    }

    public function update(UpdateNutrientControlRequest $request, NutrientControl $nutrientControl)
    {
        $nutrientControl->update($request->all());
        $nutrientControl->tags()->sync($request->input('tags', []));
        if (count($nutrientControl->image) > 0) {
            foreach ($nutrientControl->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $nutrientControl->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $nutrientControl->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new NutrientControlResource($nutrientControl))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(NutrientControl $nutrientControl)
    {
        abort_if(Gate::denies('nutrient_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $nutrientControl->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
