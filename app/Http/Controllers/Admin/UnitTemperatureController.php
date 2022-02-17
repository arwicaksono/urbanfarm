<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitTemperatureRequest;
use App\Http\Requests\StoreUnitTemperatureRequest;
use App\Http\Requests\UpdateUnitTemperatureRequest;
use App\Models\UnitTemperature;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitTemperatureController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_temperature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitTemperature::with(['team'])->select(sprintf('%s.*', (new UnitTemperature())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'unit_temperature_show';
                $editGate = 'unit_temperature_edit';
                $deleteGate = 'unit_temperature_delete';
                $crudRoutePart = 'unit-temperatures';

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

        return view('admin.unitTemperatures.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_temperature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitTemperatures.create');
    }

    public function store(StoreUnitTemperatureRequest $request)
    {
        $unitTemperature = UnitTemperature::create($request->all());

        return redirect()->route('admin.unit-temperatures.index');
    }

    public function edit(UnitTemperature $unitTemperature)
    {
        abort_if(Gate::denies('unit_temperature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitTemperature->load('team');

        return view('admin.unitTemperatures.edit', compact('unitTemperature'));
    }

    public function update(UpdateUnitTemperatureRequest $request, UnitTemperature $unitTemperature)
    {
        $unitTemperature->update($request->all());

        return redirect()->route('admin.unit-temperatures.index');
    }

    public function show(UnitTemperature $unitTemperature)
    {
        abort_if(Gate::denies('unit_temperature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitTemperature->load('team');

        return view('admin.unitTemperatures.show', compact('unitTemperature'));
    }

    public function destroy(UnitTemperature $unitTemperature)
    {
        abort_if(Gate::denies('unit_temperature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitTemperature->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitTemperatureRequest $request)
    {
        UnitTemperature::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
