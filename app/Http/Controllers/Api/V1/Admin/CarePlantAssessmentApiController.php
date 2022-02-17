<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCarePlantAssessmentRequest;
use App\Http\Requests\UpdateCarePlantAssessmentRequest;
use App\Http\Resources\Admin\CarePlantAssessmentResource;
use App\Models\CarePlantAssessment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarePlantAssessmentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_plant_assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePlantAssessmentResource(CarePlantAssessment::with(['problem_pa', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCarePlantAssessmentRequest $request)
    {
        $carePlantAssessment = CarePlantAssessment::create($request->all());
        $carePlantAssessment->tags()->sync($request->input('tags', []));
        $carePlantAssessment->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $carePlantAssessment->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CarePlantAssessmentResource($carePlantAssessment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CarePlantAssessment $carePlantAssessment)
    {
        abort_if(Gate::denies('care_plant_assessment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarePlantAssessmentResource($carePlantAssessment->load(['problem_pa', 'efficacy', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCarePlantAssessmentRequest $request, CarePlantAssessment $carePlantAssessment)
    {
        $carePlantAssessment->update($request->all());
        $carePlantAssessment->tags()->sync($request->input('tags', []));
        $carePlantAssessment->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$carePlantAssessment->image || $request->input('image') !== $carePlantAssessment->image->file_name) {
                if ($carePlantAssessment->image) {
                    $carePlantAssessment->image->delete();
                }
                $carePlantAssessment->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($carePlantAssessment->image) {
            $carePlantAssessment->image->delete();
        }

        return (new CarePlantAssessmentResource($carePlantAssessment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CarePlantAssessment $carePlantAssessment)
    {
        abort_if(Gate::denies('care_plant_assessment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePlantAssessment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
