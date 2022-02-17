<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySiteWeatherRequest;
use App\Http\Requests\StoreSiteWeatherRequest;
use App\Http\Requests\UpdateSiteWeatherRequest;
use App\Models\SiteWeather;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SiteWeatherController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('site_weather_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SiteWeather::with(['team'])->select(sprintf('%s.*', (new SiteWeather())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'site_weather_show';
                $editGate = 'site_weather_edit';
                $deleteGate = 'site_weather_delete';
                $crudRoutePart = 'site-weathers';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.siteWeathers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('site_weather_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.siteWeathers.create');
    }

    public function store(StoreSiteWeatherRequest $request)
    {
        $siteWeather = SiteWeather::create($request->all());

        return redirect()->route('admin.site-weathers.index');
    }

    public function edit(SiteWeather $siteWeather)
    {
        abort_if(Gate::denies('site_weather_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWeather->load('team');

        return view('admin.siteWeathers.edit', compact('siteWeather'));
    }

    public function update(UpdateSiteWeatherRequest $request, SiteWeather $siteWeather)
    {
        $siteWeather->update($request->all());

        return redirect()->route('admin.site-weathers.index');
    }

    public function show(SiteWeather $siteWeather)
    {
        abort_if(Gate::denies('site_weather_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWeather->load('team');

        return view('admin.siteWeathers.show', compact('siteWeather'));
    }

    public function destroy(SiteWeather $siteWeather)
    {
        abort_if(Gate::denies('site_weather_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWeather->delete();

        return back();
    }

    public function massDestroy(MassDestroySiteWeatherRequest $request)
    {
        SiteWeather::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
