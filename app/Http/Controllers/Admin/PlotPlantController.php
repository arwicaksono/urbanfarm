<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPlotPlantRequest;
use App\Http\Requests\StorePlotPlantRequest;
use App\Http\Requests\UpdatePlotPlantRequest;
use App\Models\PlotPlant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlotPlantController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('plot_plant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PlotPlant::with(['team'])->select(sprintf('%s.*', (new PlotPlant())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'plot_plant_show';
                $editGate = 'plot_plant_edit';
                $deleteGate = 'plot_plant_delete';
                $crudRoutePart = 'plot-plants';

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
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.plotPlants.index');
    }

    public function create()
    {
        abort_if(Gate::denies('plot_plant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.plotPlants.create');
    }

    public function store(StorePlotPlantRequest $request)
    {
        $plotPlant = PlotPlant::create($request->all());

        return redirect()->route('admin.plot-plants.index');
    }

    public function edit(PlotPlant $plotPlant)
    {
        abort_if(Gate::denies('plot_plant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotPlant->load('team');

        return view('admin.plotPlants.edit', compact('plotPlant'));
    }

    public function update(UpdatePlotPlantRequest $request, PlotPlant $plotPlant)
    {
        $plotPlant->update($request->all());

        return redirect()->route('admin.plot-plants.index');
    }

    public function show(PlotPlant $plotPlant)
    {
        abort_if(Gate::denies('plot_plant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotPlant->load('team');

        return view('admin.plotPlants.show', compact('plotPlant'));
    }

    public function destroy(PlotPlant $plotPlant)
    {
        abort_if(Gate::denies('plot_plant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotPlant->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlotPlantRequest $request)
    {
        PlotPlant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
