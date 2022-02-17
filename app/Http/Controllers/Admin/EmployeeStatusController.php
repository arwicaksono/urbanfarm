<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeStatusRequest;
use App\Http\Requests\StoreEmployeeStatusRequest;
use App\Http\Requests\UpdateEmployeeStatusRequest;
use App\Models\EmployeeStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeStatusController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeStatus::with(['team'])->select(sprintf('%s.*', (new EmployeeStatus())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_status_show';
                $editGate = 'employee_status_edit';
                $deleteGate = 'employee_status_delete';
                $crudRoutePart = 'employee-statuses';

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

        return view('admin.employeeStatuses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeStatuses.create');
    }

    public function store(StoreEmployeeStatusRequest $request)
    {
        $employeeStatus = EmployeeStatus::create($request->all());

        return redirect()->route('admin.employee-statuses.index');
    }

    public function edit(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeStatus->load('team');

        return view('admin.employeeStatuses.edit', compact('employeeStatus'));
    }

    public function update(UpdateEmployeeStatusRequest $request, EmployeeStatus $employeeStatus)
    {
        $employeeStatus->update($request->all());

        return redirect()->route('admin.employee-statuses.index');
    }

    public function show(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeStatus->load('team');

        return view('admin.employeeStatuses.show', compact('employeeStatus'));
    }

    public function destroy(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeStatusRequest $request)
    {
        EmployeeStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
