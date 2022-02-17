<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteWaterSourceRequest;
use App\Http\Requests\UpdateSiteWaterSourceRequest;
use App\Http\Resources\Admin\SiteWaterSourceResource;
use App\Models\SiteWaterSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteWaterSourceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('site_water_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteWaterSourceResource(SiteWaterSource::with(['team'])->get());
    }

    public function store(StoreSiteWaterSourceRequest $request)
    {
        $siteWaterSource = SiteWaterSource::create($request->all());

        return (new SiteWaterSourceResource($siteWaterSource))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SiteWaterSource $siteWaterSource)
    {
        abort_if(Gate::denies('site_water_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteWaterSourceResource($siteWaterSource->load(['team']));
    }

    public function update(UpdateSiteWaterSourceRequest $request, SiteWaterSource $siteWaterSource)
    {
        $siteWaterSource->update($request->all());

        return (new SiteWaterSourceResource($siteWaterSource))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SiteWaterSource $siteWaterSource)
    {
        abort_if(Gate::denies('site_water_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWaterSource->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
