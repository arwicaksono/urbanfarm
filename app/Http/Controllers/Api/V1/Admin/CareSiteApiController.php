<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCareSiteRequest;
use App\Http\Requests\UpdateCareSiteRequest;
use App\Http\Resources\Admin\CareSiteResource;
use App\Models\CareSite;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareSiteApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_site_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareSiteResource(CareSite::with(['problem_si', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCareSiteRequest $request)
    {
        $careSite = CareSite::create($request->all());
        $careSite->tags()->sync($request->input('tags', []));
        $careSite->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $careSite->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CareSiteResource($careSite))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CareSite $careSite)
    {
        abort_if(Gate::denies('care_site_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareSiteResource($careSite->load(['problem_si', 'efficacy', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCareSiteRequest $request, CareSite $careSite)
    {
        $careSite->update($request->all());
        $careSite->tags()->sync($request->input('tags', []));
        $careSite->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$careSite->image || $request->input('image') !== $careSite->image->file_name) {
                if ($careSite->image) {
                    $careSite->image->delete();
                }
                $careSite->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($careSite->image) {
            $careSite->image->delete();
        }

        return (new CareSiteResource($careSite))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CareSite $careSite)
    {
        abort_if(Gate::denies('care_site_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careSite->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
