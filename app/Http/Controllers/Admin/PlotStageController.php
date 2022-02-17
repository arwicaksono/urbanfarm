<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPlotStageRequest;
use App\Http\Requests\StorePlotStageRequest;
use App\Http\Requests\UpdatePlotStageRequest;
use App\Models\PlotStage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlotStageController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('plot_stage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PlotStage::with(['team'])->select(sprintf('%s.*', (new PlotStage())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'plot_stage_show';
                $editGate = 'plot_stage_edit';
                $deleteGate = 'plot_stage_delete';
                $crudRoutePart = 'plot-stages';

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
            $table->editColumn('period', function ($row) {
                return $row->period ? $row->period : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.plotStages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('plot_stage_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.plotStages.create');
    }

    public function store(StorePlotStageRequest $request)
    {
        $plotStage = PlotStage::create($request->all());

        return redirect()->route('admin.plot-stages.index');
    }

    public function edit(PlotStage $plotStage)
    {
        abort_if(Gate::denies('plot_stage_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotStage->load('team');

        return view('admin.plotStages.edit', compact('plotStage'));
    }

    public function update(UpdatePlotStageRequest $request, PlotStage $plotStage)
    {
        $plotStage->update($request->all());

        return redirect()->route('admin.plot-stages.index');
    }

    public function show(PlotStage $plotStage)
    {
        abort_if(Gate::denies('plot_stage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotStage->load('team');

        return view('admin.plotStages.show', compact('plotStage'));
    }

    public function destroy(PlotStage $plotStage)
    {
        abort_if(Gate::denies('plot_stage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotStage->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlotStageRequest $request)
    {
        PlotStage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
