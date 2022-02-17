<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCareModuleRequest;
use App\Http\Requests\UpdateCareModuleRequest;
use App\Http\Resources\Admin\CareModuleResource;
use App\Models\CareModule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareModuleApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareModuleResource(CareModule::with(['problem_mo', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCareModuleRequest $request)
    {
        $careModule = CareModule::create($request->all());
        $careModule->tags()->sync($request->input('tags', []));
        $careModule->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $careModule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CareModuleResource($careModule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CareModule $careModule)
    {
        abort_if(Gate::denies('care_module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareModuleResource($careModule->load(['problem_mo', 'efficacy', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCareModuleRequest $request, CareModule $careModule)
    {
        $careModule->update($request->all());
        $careModule->tags()->sync($request->input('tags', []));
        $careModule->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$careModule->image || $request->input('image') !== $careModule->image->file_name) {
                if ($careModule->image) {
                    $careModule->image->delete();
                }
                $careModule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($careModule->image) {
            $careModule->image->delete();
        }

        return (new CareModuleResource($careModule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CareModule $careModule)
    {
        abort_if(Gate::denies('care_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careModule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
