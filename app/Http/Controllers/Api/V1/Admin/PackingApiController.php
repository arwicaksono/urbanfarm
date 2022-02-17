<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePackingRequest;
use App\Http\Requests\UpdatePackingRequest;
use App\Http\Resources\Admin\PackingResource;
use App\Models\Packing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PackingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('packing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PackingResource(Packing::with(['harvest_codes', 'status', 'tags', 'priority', 'person_in_charge', 'team'])->get());
    }

    public function store(StorePackingRequest $request)
    {
        $packing = Packing::create($request->all());
        $packing->harvest_codes()->sync($request->input('harvest_codes', []));
        $packing->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $packing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new PackingResource($packing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Packing $packing)
    {
        abort_if(Gate::denies('packing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PackingResource($packing->load(['harvest_codes', 'status', 'tags', 'priority', 'person_in_charge', 'team']));
    }

    public function update(UpdatePackingRequest $request, Packing $packing)
    {
        $packing->update($request->all());
        $packing->harvest_codes()->sync($request->input('harvest_codes', []));
        $packing->tags()->sync($request->input('tags', []));
        if (count($packing->image) > 0) {
            foreach ($packing->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $packing->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $packing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new PackingResource($packing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Packing $packing)
    {
        abort_if(Gate::denies('packing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
