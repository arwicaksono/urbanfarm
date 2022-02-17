<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCareNutrientControlRequest;
use App\Http\Requests\UpdateCareNutrientControlRequest;
use App\Http\Resources\Admin\CareNutrientControlResource;
use App\Models\CareNutrientControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareNutrientControlApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_nutrient_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareNutrientControlResource(CareNutrientControl::with(['problem_nc', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCareNutrientControlRequest $request)
    {
        $careNutrientControl = CareNutrientControl::create($request->all());
        $careNutrientControl->tags()->sync($request->input('tags', []));
        $careNutrientControl->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $careNutrientControl->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CareNutrientControlResource($careNutrientControl))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CareNutrientControl $careNutrientControl)
    {
        abort_if(Gate::denies('care_nutrient_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareNutrientControlResource($careNutrientControl->load(['problem_nc', 'efficacy', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCareNutrientControlRequest $request, CareNutrientControl $careNutrientControl)
    {
        $careNutrientControl->update($request->all());
        $careNutrientControl->tags()->sync($request->input('tags', []));
        $careNutrientControl->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$careNutrientControl->image || $request->input('image') !== $careNutrientControl->image->file_name) {
                if ($careNutrientControl->image) {
                    $careNutrientControl->image->delete();
                }
                $careNutrientControl->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($careNutrientControl->image) {
            $careNutrientControl->image->delete();
        }

        return (new CareNutrientControlResource($careNutrientControl))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CareNutrientControl $careNutrientControl)
    {
        abort_if(Gate::denies('care_nutrient_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careNutrientControl->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
