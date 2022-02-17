<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeePositionRequest;
use App\Http\Requests\UpdateEmployeePositionRequest;
use App\Http\Resources\Admin\EmployeePositionResource;
use App\Models\EmployeePosition;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeePositionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_position_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeePositionResource(EmployeePosition::with(['team'])->get());
    }

    public function store(StoreEmployeePositionRequest $request)
    {
        $employeePosition = EmployeePosition::create($request->all());

        return (new EmployeePositionResource($employeePosition))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeePosition $employeePosition)
    {
        abort_if(Gate::denies('employee_position_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeePositionResource($employeePosition->load(['team']));
    }

    public function update(UpdateEmployeePositionRequest $request, EmployeePosition $employeePosition)
    {
        $employeePosition->update($request->all());

        return (new EmployeePositionResource($employeePosition))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeePosition $employeePosition)
    {
        abort_if(Gate::denies('employee_position_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeePosition->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
