<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSiteInspectionRequest;
use App\Http\Requests\UpdateSiteInspectionRequest;
use App\Http\Resources\Admin\SiteInspectionResource;
use App\Models\SiteInspection;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteInspectionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('site_inspection_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteInspectionResource(SiteInspection::with(['site', 'weather', 'tags', 'priority', 'person_in_charge', 'team'])->get());
    }

    public function store(StoreSiteInspectionRequest $request)
    {
        $siteInspection = SiteInspection::create($request->all());
        $siteInspection->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $siteInspection->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new SiteInspectionResource($siteInspection))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SiteInspection $siteInspection)
    {
        abort_if(Gate::denies('site_inspection_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteInspectionResource($siteInspection->load(['site', 'weather', 'tags', 'priority', 'person_in_charge', 'team']));
    }

    public function update(UpdateSiteInspectionRequest $request, SiteInspection $siteInspection)
    {
        $siteInspection->update($request->all());
        $siteInspection->tags()->sync($request->input('tags', []));
        if (count($siteInspection->image) > 0) {
            foreach ($siteInspection->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $siteInspection->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $siteInspection->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new SiteInspectionResource($siteInspection))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SiteInspection $siteInspection)
    {
        abort_if(Gate::denies('site_inspection_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteInspection->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
