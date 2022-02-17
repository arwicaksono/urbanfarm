<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEmployeeAttendanceRequest;
use App\Http\Requests\UpdateEmployeeAttendanceRequest;
use App\Http\Resources\Admin\EmployeeAttendanceResource;
use App\Models\EmployeeAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAttendanceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeAttendanceResource(EmployeeAttendance::with(['name', 'team'])->get());
    }

    public function store(StoreEmployeeAttendanceRequest $request)
    {
        $employeeAttendance = EmployeeAttendance::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $employeeAttendance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new EmployeeAttendanceResource($employeeAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeAttendance $employeeAttendance)
    {
        abort_if(Gate::denies('employee_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeAttendanceResource($employeeAttendance->load(['name', 'team']));
    }

    public function update(UpdateEmployeeAttendanceRequest $request, EmployeeAttendance $employeeAttendance)
    {
        $employeeAttendance->update($request->all());

        if (count($employeeAttendance->image) > 0) {
            foreach ($employeeAttendance->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $employeeAttendance->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $employeeAttendance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new EmployeeAttendanceResource($employeeAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeAttendance $employeeAttendance)
    {
        abort_if(Gate::denies('employee_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAttendance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
