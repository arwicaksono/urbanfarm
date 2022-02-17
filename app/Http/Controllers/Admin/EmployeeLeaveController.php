<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeLeaveRequest;
use App\Http\Requests\StoreEmployeeLeaveRequest;
use App\Http\Requests\UpdateEmployeeLeaveRequest;
use App\Models\EmpLeaveType;
use App\Models\EmployeeLeave;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeLeaveController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_leave_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeLeave::with(['name', 'leave_type', 'team'])->select(sprintf('%s.*', (new EmployeeLeave())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_leave_show';
                $editGate = 'employee_leave_edit';
                $deleteGate = 'employee_leave_delete';
                $crudRoutePart = 'employee-leaves';

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
            $table->addColumn('name_name', function ($row) {
                return $row->name ? $row->name->name : '';
            });

            $table->addColumn('leave_type_name', function ($row) {
                return $row->leave_type ? $row->leave_type->name : '';
            });

            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'name', 'leave_type']);

            return $table->make(true);
        }

        return view('admin.employeeLeaves.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_leave_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $names = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_types = EmpLeaveType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeLeaves.create', compact('leave_types', 'names'));
    }

    public function store(StoreEmployeeLeaveRequest $request)
    {
        $employeeLeave = EmployeeLeave::create($request->all());

        return redirect()->route('admin.employee-leaves.index');
    }

    public function edit(EmployeeLeave $employeeLeave)
    {
        abort_if(Gate::denies('employee_leave_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $names = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_types = EmpLeaveType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeLeave->load('name', 'leave_type', 'team');

        return view('admin.employeeLeaves.edit', compact('employeeLeave', 'leave_types', 'names'));
    }

    public function update(UpdateEmployeeLeaveRequest $request, EmployeeLeave $employeeLeave)
    {
        $employeeLeave->update($request->all());

        return redirect()->route('admin.employee-leaves.index');
    }

    public function show(EmployeeLeave $employeeLeave)
    {
        abort_if(Gate::denies('employee_leave_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeLeave->load('name', 'leave_type', 'team');

        return view('admin.employeeLeaves.show', compact('employeeLeave'));
    }

    public function destroy(EmployeeLeave $employeeLeave)
    {
        abort_if(Gate::denies('employee_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeLeave->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeLeaveRequest $request)
    {
        EmployeeLeave::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
