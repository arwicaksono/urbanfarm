<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySiteWaterSourceRequest;
use App\Http\Requests\StoreSiteWaterSourceRequest;
use App\Http\Requests\UpdateSiteWaterSourceRequest;
use App\Models\SiteWaterSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SiteWaterSourceController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('site_water_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SiteWaterSource::with(['team'])->select(sprintf('%s.*', (new SiteWaterSource())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'site_water_source_show';
                $editGate = 'site_water_source_edit';
                $deleteGate = 'site_water_source_delete';
                $crudRoutePart = 'site-water-sources';

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

        return view('admin.siteWaterSources.index');
    }

    public function create()
    {
        abort_if(Gate::denies('site_water_source_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.siteWaterSources.create');
    }

    public function store(StoreSiteWaterSourceRequest $request)
    {
        $siteWaterSource = SiteWaterSource::create($request->all());

        return redirect()->route('admin.site-water-sources.index');
    }

    public function edit(SiteWaterSource $siteWaterSource)
    {
        abort_if(Gate::denies('site_water_source_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWaterSource->load('team');

        return view('admin.siteWaterSources.edit', compact('siteWaterSource'));
    }

    public function update(UpdateSiteWaterSourceRequest $request, SiteWaterSource $siteWaterSource)
    {
        $siteWaterSource->update($request->all());

        return redirect()->route('admin.site-water-sources.index');
    }

    public function show(SiteWaterSource $siteWaterSource)
    {
        abort_if(Gate::denies('site_water_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWaterSource->load('team');

        return view('admin.siteWaterSources.show', compact('siteWaterSource'));
    }

    public function destroy(SiteWaterSource $siteWaterSource)
    {
        abort_if(Gate::denies('site_water_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteWaterSource->delete();

        return back();
    }

    public function massDestroy(MassDestroySiteWaterSourceRequest $request)
    {
        SiteWaterSource::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
