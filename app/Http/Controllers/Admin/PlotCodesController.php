<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPlotCodeRequest;
use App\Http\Requests\StorePlotCodeRequest;
use App\Http\Requests\UpdatePlotCodeRequest;
use App\Models\PlotCode;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlotCodesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('plot_code_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PlotCode::with(['team'])->select(sprintf('%s.*', (new PlotCode())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'plot_code_show';
                $editGate = 'plot_code_edit';
                $deleteGate = 'plot_code_delete';
                $crudRoutePart = 'plot-codes';

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
            $table->editColumn('prefix', function ($row) {
                return $row->prefix ? $row->prefix : '';
            });
            $table->editColumn('plant', function ($row) {
                return $row->plant ? $row->plant : '';
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.plotCodes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('plot_code_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.plotCodes.create');
    }

    public function store(StorePlotCodeRequest $request)
    {
        $plotCode = PlotCode::create($request->all());

        return redirect()->route('admin.plot-codes.index');
    }

    public function edit(PlotCode $plotCode)
    {
        abort_if(Gate::denies('plot_code_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotCode->load('team');

        return view('admin.plotCodes.edit', compact('plotCode'));
    }

    public function update(UpdatePlotCodeRequest $request, PlotCode $plotCode)
    {
        $plotCode->update($request->all());

        return redirect()->route('admin.plot-codes.index');
    }

    public function show(PlotCode $plotCode)
    {
        abort_if(Gate::denies('plot_code_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotCode->load('team');

        return view('admin.plotCodes.show', compact('plotCode'));
    }

    public function destroy(PlotCode $plotCode)
    {
        abort_if(Gate::denies('plot_code_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plotCode->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlotCodeRequest $request)
    {
        PlotCode::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
