<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEmployeeJobDescRequest;
use App\Http\Requests\UpdateEmployeeJobDescRequest;
use App\Http\Resources\Admin\EmployeeJobDescResource;
use App\Models\EmployeeJobDesc;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeJobDescApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_job_desc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeJobDescResource(EmployeeJobDesc::with(['position', 'team'])->get());
    }

    public function store(StoreEmployeeJobDescRequest $request)
    {
        $employeeJobDesc = EmployeeJobDesc::create($request->all());

        return (new EmployeeJobDescResource($employeeJobDesc))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeJobDesc $employeeJobDesc)
    {
        abort_if(Gate::denies('employee_job_desc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeJobDescResource($employeeJobDesc->load(['position', 'team']));
    }

    public function update(UpdateEmployeeJobDescRequest $request, EmployeeJobDesc $employeeJobDesc)
    {
        $employeeJobDesc->update($request->all());

        return (new EmployeeJobDescResource($employeeJobDesc))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeJobDesc $employeeJobDesc)
    {
        abort_if(Gate::denies('employee_job_desc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeJobDesc->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
