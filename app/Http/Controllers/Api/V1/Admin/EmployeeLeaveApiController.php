<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeLeaveRequest;
use App\Http\Requests\UpdateEmployeeLeaveRequest;
use App\Http\Resources\Admin\EmployeeLeaveResource;
use App\Models\EmployeeLeave;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeLeaveApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_leave_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeLeaveResource(EmployeeLeave::with(['name', 'leave_type', 'team'])->get());
    }

    public function store(StoreEmployeeLeaveRequest $request)
    {
        $employeeLeave = EmployeeLeave::create($request->all());

        return (new EmployeeLeaveResource($employeeLeave))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeLeave $employeeLeave)
    {
        abort_if(Gate::denies('employee_leave_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeLeaveResource($employeeLeave->load(['name', 'leave_type', 'team']));
    }

    public function update(UpdateEmployeeLeaveRequest $request, EmployeeLeave $employeeLeave)
    {
        $employeeLeave->update($request->all());

        return (new EmployeeLeaveResource($employeeLeave))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeLeave $employeeLeave)
    {
        abort_if(Gate::denies('employee_leave_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeLeave->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
