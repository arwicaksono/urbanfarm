<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUnitAgeRequest;
use App\Http\Requests\StoreUnitAgeRequest;
use App\Http\Requests\UpdateUnitAgeRequest;
use App\Models\UnitAge;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitAgeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_age_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitAge::with(['team'])->select(sprintf('%s.*', (new UnitAge())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'unit_age_show';
                $editGate = 'unit_age_edit';
                $deleteGate = 'unit_age_delete';
                $crudRoutePart = 'unit-ages';

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

        return view('admin.unitAges.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_age_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitAges.create');
    }

    public function store(StoreUnitAgeRequest $request)
    {
        $unitAge = UnitAge::create($request->all());

        return redirect()->route('admin.unit-ages.index');
    }

    public function edit(UnitAge $unitAge)
    {
        abort_if(Gate::denies('unit_age_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitAge->load('team');

        return view('admin.unitAges.edit', compact('unitAge'));
    }

    public function update(UpdateUnitAgeRequest $request, UnitAge $unitAge)
    {
        $unitAge->update($request->all());

        return redirect()->route('admin.unit-ages.index');
    }

    public function show(UnitAge $unitAge)
    {
        abort_if(Gate::denies('unit_age_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitAge->load('team');

        return view('admin.unitAges.show', compact('unitAge'));
    }

    public function destroy(UnitAge $unitAge)
    {
        abort_if(Gate::denies('unit_age_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitAge->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitAgeRequest $request)
    {
        UnitAge::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
