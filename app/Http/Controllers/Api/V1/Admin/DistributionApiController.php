<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDistributionRequest;
use App\Http\Requests\UpdateDistributionRequest;
use App\Http\Resources\Admin\DistributionResource;
use App\Models\Distribution;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DistributionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DistributionResource(Distribution::with(['packing_codes', 'customer', 'channel', 'market', 'delivery', 'status', 'tags', 'priority', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreDistributionRequest $request)
    {
        $distribution = Distribution::create($request->all());
        $distribution->packing_codes()->sync($request->input('packing_codes', []));
        $distribution->tags()->sync($request->input('tags', []));
        $distribution->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $distribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new DistributionResource($distribution))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Distribution $distribution)
    {
        abort_if(Gate::denies('distribution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DistributionResource($distribution->load(['packing_codes', 'customer', 'channel', 'market', 'delivery', 'status', 'tags', 'priority', 'person_in_charges', 'team']));
    }

    public function update(UpdateDistributionRequest $request, Distribution $distribution)
    {
        $distribution->update($request->all());
        $distribution->packing_codes()->sync($request->input('packing_codes', []));
        $distribution->tags()->sync($request->input('tags', []));
        $distribution->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($distribution->image) > 0) {
            foreach ($distribution->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $distribution->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $distribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new DistributionResource($distribution))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Distribution $distribution)
    {
        abort_if(Gate::denies('distribution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $distribution->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
