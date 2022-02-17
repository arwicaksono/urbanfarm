<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitQuantityRequest;
use App\Http\Requests\StoreUnitQuantityRequest;
use App\Http\Requests\UpdateUnitQuantityRequest;
use App\Models\UnitQuantity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitQuantityController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_quantity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitQuantity::with(['team'])->select(sprintf('%s.*', (new UnitQuantity())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'unit_quantity_show';
                $editGate = 'unit_quantity_edit';
                $deleteGate = 'unit_quantity_delete';
                $crudRoutePart = 'unit-quantities';

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

        return view('admin.unitQuantities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_quantity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitQuantities.create');
    }

    public function store(StoreUnitQuantityRequest $request)
    {
        $unitQuantity = UnitQuantity::create($request->all());

        return redirect()->route('admin.unit-quantities.index');
    }

    public function edit(UnitQuantity $unitQuantity)
    {
        abort_if(Gate::denies('unit_quantity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitQuantity->load('team');

        return view('admin.unitQuantities.edit', compact('unitQuantity'));
    }

    public function update(UpdateUnitQuantityRequest $request, UnitQuantity $unitQuantity)
    {
        $unitQuantity->update($request->all());

        return redirect()->route('admin.unit-quantities.index');
    }

    public function show(UnitQuantity $unitQuantity)
    {
        abort_if(Gate::denies('unit_quantity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitQuantity->load('team');

        return view('admin.unitQuantities.show', compact('unitQuantity'));
    }

    public function destroy(UnitQuantity $unitQuantity)
    {
        abort_if(Gate::denies('unit_quantity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitQuantity->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitQuantityRequest $request)
    {
        UnitQuantity::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
