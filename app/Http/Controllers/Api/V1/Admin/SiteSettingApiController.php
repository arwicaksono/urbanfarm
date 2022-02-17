<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteSettingRequest;
use App\Http\Requests\UpdateSiteSettingRequest;
use App\Http\Resources\Admin\SiteSettingResource;
use App\Models\SiteSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteSettingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('site_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteSettingResource(SiteSetting::with(['team'])->get());
    }

    public function store(StoreSiteSettingRequest $request)
    {
        $siteSetting = SiteSetting::create($request->all());

        return (new SiteSettingResource($siteSetting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SiteSetting $siteSetting)
    {
        abort_if(Gate::denies('site_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteSettingResource($siteSetting->load(['team']));
    }

    public function update(UpdateSiteSettingRequest $request, SiteSetting $siteSetting)
    {
        $siteSetting->update($request->all());

        return (new SiteSettingResource($siteSetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SiteSetting $siteSetting)
    {
        abort_if(Gate::denies('site_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteSetting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
