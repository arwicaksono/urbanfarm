<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmpLeaveTypeRequest;
use App\Http\Requests\UpdateEmpLeaveTypeRequest;
use App\Http\Resources\Admin\EmpLeaveTypeResource;
use App\Models\EmpLeaveType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpLeaveTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('emp_leave_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmpLeaveTypeResource(EmpLeaveType::all());
    }

    public function store(StoreEmpLeaveTypeRequest $request)
    {
        $empLeaveType = EmpLeaveType::create($request->all());

        return (new EmpLeaveTypeResource($empLeaveType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmpLeaveType $empLeaveType)
    {
        abort_if(Gate::denies('emp_leave_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmpLeaveTypeResource($empLeaveType);
    }

    public function update(UpdateEmpLeaveTypeRequest $request, EmpLeaveType $empLeaveType)
    {
        $empLeaveType->update($request->all());

        return (new EmpLeaveTypeResource($empLeaveType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmpLeaveType $empLeaveType)
    {
        abort_if(Gate::denies('emp_leave_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empLeaveType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
