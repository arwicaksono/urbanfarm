<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\Admin\SiteResource;
use App\Models\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('site_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteResource(Site::with(['unit', 'settings', 'water_sources', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreSiteRequest $request)
    {
        $site = Site::create($request->all());
        $site->settings()->sync($request->input('settings', []));
        $site->water_sources()->sync($request->input('water_sources', []));
        $site->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $site->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new SiteResource($site))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Site $site)
    {
        abort_if(Gate::denies('site_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteResource($site->load(['unit', 'settings', 'water_sources', 'person_in_charges', 'team']));
    }

    public function update(UpdateSiteRequest $request, Site $site)
    {
        $site->update($request->all());
        $site->settings()->sync($request->input('settings', []));
        $site->water_sources()->sync($request->input('water_sources', []));
        $site->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($site->image) > 0) {
            foreach ($site->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $site->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $site->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new SiteResource($site))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Site $site)
    {
        abort_if(Gate::denies('site_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
