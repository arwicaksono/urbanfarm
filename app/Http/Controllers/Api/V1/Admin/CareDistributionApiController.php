<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCareDistributionRequest;
use App\Http\Requests\UpdateCareDistributionRequest;
use App\Http\Resources\Admin\CareDistributionResource;
use App\Models\CareDistribution;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareDistributionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareDistributionResource(CareDistribution::with(['problem_dist', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCareDistributionRequest $request)
    {
        $careDistribution = CareDistribution::create($request->all());
        $careDistribution->tags()->sync($request->input('tags', []));
        $careDistribution->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $careDistribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CareDistributionResource($careDistribution))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CareDistribution $careDistribution)
    {
        abort_if(Gate::denies('care_distribution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareDistributionResource($careDistribution->load(['problem_dist', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCareDistributionRequest $request, CareDistribution $careDistribution)
    {
        $careDistribution->update($request->all());
        $careDistribution->tags()->sync($request->input('tags', []));
        $careDistribution->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($careDistribution->image) > 0) {
            foreach ($careDistribution->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $careDistribution->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $careDistribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CareDistributionResource($careDistribution))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CareDistribution $careDistribution)
    {
        abort_if(Gate::denies('care_distribution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careDistribution->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
