<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeePositionRequest;
use App\Http\Requests\StoreEmployeePositionRequest;
use App\Http\Requests\UpdateEmployeePositionRequest;
use App\Models\EmployeePosition;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeePositionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_position_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeePosition::with(['team'])->select(sprintf('%s.*', (new EmployeePosition())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_position_show';
                $editGate = 'employee_position_edit';
                $deleteGate = 'employee_position_delete';
                $crudRoutePart = 'employee-positions';

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

        return view('admin.employeePositions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_position_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeePositions.create');
    }

    public function store(StoreEmployeePositionRequest $request)
    {
        $employeePosition = EmployeePosition::create($request->all());

        return redirect()->route('admin.employee-positions.index');
    }

    public function edit(EmployeePosition $employeePosition)
    {
        abort_if(Gate::denies('employee_position_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeePosition->load('team');

        return view('admin.employeePositions.edit', compact('employeePosition'));
    }

    public function update(UpdateEmployeePositionRequest $request, EmployeePosition $employeePosition)
    {
        $employeePosition->update($request->all());

        return redirect()->route('admin.employee-positions.index');
    }

    public function show(EmployeePosition $employeePosition)
    {
        abort_if(Gate::denies('employee_position_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeePosition->load('team');

        return view('admin.employeePositions.show', compact('employeePosition'));
    }

    public function destroy(EmployeePosition $employeePosition)
    {
        abort_if(Gate::denies('employee_position_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeePosition->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeePositionRequest $request)
    {
        EmployeePosition::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
