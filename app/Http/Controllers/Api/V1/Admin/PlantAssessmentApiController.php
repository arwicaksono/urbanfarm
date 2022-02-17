<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePlantAssessmentRequest;
use App\Http\Requests\UpdatePlantAssessmentRequest;
use App\Http\Resources\Admin\PlantAssessmentResource;
use App\Models\PlantAssessment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlantAssessmentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('plant_assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlantAssessmentResource(PlantAssessment::with(['plot', 'unit', 'tags', 'priority', 'person_in_charge', 'team'])->get());
    }

    public function store(StorePlantAssessmentRequest $request)
    {
        $plantAssessment = PlantAssessment::create($request->all());
        $plantAssessment->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $plantAssessment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PlantAssessmentResource($plantAssessment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PlantAssessment $plantAssessment)
    {
        abort_if(Gate::denies('plant_assessment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlantAssessmentResource($plantAssessment->load(['plot', 'unit', 'tags', 'priority', 'person_in_charge', 'team']));
    }

    public function update(UpdatePlantAssessmentRequest $request, PlantAssessment $plantAssessment)
    {
        $plantAssessment->update($request->all());
        $plantAssessment->tags()->sync($request->input('tags', []));
        if (count($plantAssessment->image) > 0) {
            foreach ($plantAssessment->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $plantAssessment->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $plantAssessment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PlantAssessmentResource($plantAssessment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PlantAssessment $plantAssessment)
    {
        abort_if(Gate::denies('plant_assessment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plantAssessment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
