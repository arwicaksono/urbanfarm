<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiteWeatherRequest;
use App\Http\Requests\UpdateSiteWeatherRequest;
use App\Http\Resources\Admin\SiteWeatherResource;
use App\Models\SiteWeather;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteWeatherApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('site_weather_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteWeatherResource(SiteWeather::with(['team'])->get());
    }

    public function store(StoreSiteWeatherRequest $request)
    {
        $siteWeather = SiteWeather::create($request->all());

        return (new SiteWeatherResource($siteWeather))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SiteWeather $siteWeather)
    {
        abort_if(Gate::denies('site_weather_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteWeatherResource($siteWeather->load(['team']));
    }

    public function update(UpdateSiteWeatherRequest $request, SiteWeather $siteWeather)
    {
        $siteWeather->update($request->all());

        return (new SiteWeatherResource($siteWeather))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SiteWeather $siteWeather)
    {
        abort_if(Gate::denies('site_weather_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWeather->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
