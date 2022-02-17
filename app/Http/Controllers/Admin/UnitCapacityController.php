<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitCapacityRequest;
use App\Http\Requests\StoreUnitCapacityRequest;
use App\Http\Requests\UpdateUnitCapacityRequest;
use App\Models\UnitCapacity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitCapacityController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_capacity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitCapacity::with(['team'])->select(sprintf('%s.*', (new UnitCapacity())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'unit_capacity_show';
                $editGate = 'unit_capacity_edit';
                $deleteGate = 'unit_capacity_delete';
                $crudRoutePart = 'unit-capacities';

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

        return view('admin.unitCapacities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_capacity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitCapacities.create');
    }

    public function store(StoreUnitCapacityRequest $request)
    {
        $unitCapacity = UnitCapacity::create($request->all());

        return redirect()->route('admin.unit-capacities.index');
    }

    public function edit(UnitCapacity $unitCapacity)
    {
        abort_if(Gate::denies('unit_capacity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitCapacity->load('team');

        return view('admin.unitCapacities.edit', compact('unitCapacity'));
    }

    public function update(UpdateUnitCapacityRequest $request, UnitCapacity $unitCapacity)
    {
        $unitCapacity->update($request->all());

        return redirect()->route('admin.unit-capacities.index');
    }

    public function show(UnitCapacity $unitCapacity)
    {
        abort_if(Gate::denies('unit_capacity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitCapacity->load('team');

        return view('admin.unitCapacities.show', compact('unitCapacity'));
    }

    public function destroy(UnitCapacity $unitCapacity)
    {
        abort_if(Gate::denies('unit_capacity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitCapacity->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitCapacityRequest $request)
    {
        UnitCapacity::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
