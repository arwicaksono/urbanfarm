<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitWeightRequest;
use App\Http\Requests\StoreUnitWeightRequest;
use App\Http\Requests\UpdateUnitWeightRequest;
use App\Models\UnitWeight;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitWeightController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_weight_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitWeight::with(['team'])->select(sprintf('%s.*', (new UnitWeight())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'unit_weight_show';
                $editGate = 'unit_weight_edit';
                $deleteGate = 'unit_weight_delete';
                $crudRoutePart = 'unit-weights';

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

        return view('admin.unitWeights.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_weight_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitWeights.create');
    }

    public function store(StoreUnitWeightRequest $request)
    {
        $unitWeight = UnitWeight::create($request->all());

        return redirect()->route('admin.unit-weights.index');
    }

    public function edit(UnitWeight $unitWeight)
    {
        abort_if(Gate::denies('unit_weight_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitWeight->load('team');

        return view('admin.unitWeights.edit', compact('unitWeight'));
    }

    public function update(UpdateUnitWeightRequest $request, UnitWeight $unitWeight)
    {
        $unitWeight->update($request->all());

        return redirect()->route('admin.unit-weights.index');
    }

    public function show(UnitWeight $unitWeight)
    {
        abort_if(Gate::denies('unit_weight_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitWeight->load('team');

        return view('admin.unitWeights.show', compact('unitWeight'));
    }

    public function destroy(UnitWeight $unitWeight)
    {
        abort_if(Gate::denies('unit_weight_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitWeight->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitWeightRequest $request)
    {
        UnitWeight::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
