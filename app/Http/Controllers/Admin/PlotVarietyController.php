<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPlotVarietyRequest;
use App\Http\Requests\StorePlotVarietyRequest;
use App\Http\Requests\UpdatePlotVarietyRequest;
use App\Models\PlotVariety;
use App\Models\PurchaseBrand;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlotVarietyController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('plot_variety_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PlotVariety::with(['brand', 'team'])->select(sprintf('%s.*', (new PlotVariety())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'plot_variety_show';
                $editGate = 'plot_variety_edit';
                $deleteGate = 'plot_variety_delete';
                $crudRoutePart = 'plot-varieties';

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
            $table->addColumn('brand_name', function ($row) {
                return $row->brand ? $row->brand->name : '';
            });

            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'brand']);

            return $table->make(true);
        }

        return view('admin.plotVarieties.index');
    }

    public function create()
    {
        abort_if(Gate::denies('plot_variety_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brands = PurchaseBrand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.plotVarieties.create', compact('brands'));
    }

    public function store(StorePlotVarietyRequest $request)
    {
        $plotVariety = PlotVariety::create($request->all());

        return redirect()->route('admin.plot-varieties.index');
    }

    public function edit(PlotVariety $plotVariety)
    {
        abort_if(Gate::denies('plot_variety_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brands = PurchaseBrand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plotVariety->load('brand', 'team');

        return view('admin.plotVarieties.edit', compact('brands', 'plotVariety'));
    }

    public function update(UpdatePlotVarietyRequest $request, PlotVariety $plotVariety)
    {
        $plotVariety->update($request->all());

        return redirect()->route('admin.plot-varieties.index');
    }

    public function show(PlotVariety $plotVariety)
    {
        abort_if(Gate::denies('plot_variety_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotVariety->load('brand', 'team');

        return view('admin.plotVarieties.show', compact('plotVariety'));
    }

    public function destroy(PlotVariety $plotVariety)
    {
        abort_if(Gate::denies('plot_variety_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotVariety->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlotVarietyRequest $request)
    {
        PlotVariety::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
