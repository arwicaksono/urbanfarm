<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmpLeaveTypeRequest;
use App\Http\Requests\StoreEmpLeaveTypeRequest;
use App\Http\Requests\UpdateEmpLeaveTypeRequest;
use App\Models\EmpLeaveType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmpLeaveTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('emp_leave_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmpLeaveType::query()->select(sprintf('%s.*', (new EmpLeaveType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'emp_leave_type_show';
                $editGate = 'emp_leave_type_edit';
                $deleteGate = 'emp_leave_type_delete';
                $crudRoutePart = 'emp-leave-types';

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
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.empLeaveTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('emp_leave_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empLeaveTypes.create');
    }

    public function store(StoreEmpLeaveTypeRequest $request)
    {
        $empLeaveType = EmpLeaveType::create($request->all());

        return redirect()->route('admin.emp-leave-types.index');
    }

    public function edit(EmpLeaveType $empLeaveType)
    {
        abort_if(Gate::denies('emp_leave_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empLeaveTypes.edit', compact('empLeaveType'));
    }

    public function update(UpdateEmpLeaveTypeRequest $request, EmpLeaveType $empLeaveType)
    {
        $empLeaveType->update($request->all());

        return redirect()->route('admin.emp-leave-types.index');
    }

    public function show(EmpLeaveType $empLeaveType)
    {
        abort_if(Gate::denies('emp_leave_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empLeaveTypes.show', compact('empLeaveType'));
    }

    public function destroy(EmpLeaveType $empLeaveType)
    {
        abort_if(Gate::denies('emp_leave_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empLeaveType->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmpLeaveTypeRequest $request)
    {
        EmpLeaveType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
