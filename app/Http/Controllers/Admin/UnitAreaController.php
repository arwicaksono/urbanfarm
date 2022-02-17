<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitAreaRequest;
use App\Http\Requests\StoreUnitAreaRequest;
use App\Http\Requests\UpdateUnitAreaRequest;
use App\Models\UnitArea;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitAreaController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitArea::with(['team'])->select(sprintf('%s.*', (new UnitArea())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'unit_area_show';
                $editGate = 'unit_area_edit';
                $deleteGate = 'unit_area_delete';
                $crudRoutePart = 'unit-areas';

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
            $table->editColumn('metric', function ($row) {
                return $row->metric ? $row->metric : '';
            });
            $table->editColumn('imperial', function ($row) {
                return $row->imperial ? $row->imperial : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.unitAreas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_area_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitAreas.create');
    }

    public function store(StoreUnitAreaRequest $request)
    {
        $unitArea = UnitArea::create($request->all());

        return redirect()->route('admin.unit-areas.index');
    }

    public function edit(UnitArea $unitArea)
    {
        abort_if(Gate::denies('unit_area_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitArea->load('team');

        return view('admin.unitAreas.edit', compact('unitArea'));
    }

    public function update(UpdateUnitAreaRequest $request, UnitArea $unitArea)
    {
        $unitArea->update($request->all());

        return redirect()->route('admin.unit-areas.index');
    }

    public function show(UnitArea $unitArea)
    {
        abort_if(Gate::denies('unit_area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitArea->load('team');

        return view('admin.unitAreas.show', compact('unitArea'));
    }

    public function destroy(UnitArea $unitArea)
    {
        abort_if(Gate::denies('unit_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitArea->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitAreaRequest $request)
    {
        UnitArea::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
