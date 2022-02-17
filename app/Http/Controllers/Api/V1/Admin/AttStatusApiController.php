<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttStatusRequest;
use App\Http\Requests\UpdateAttStatusRequest;
use App\Http\Resources\Admin\AttStatusResource;
use App\Models\AttStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttStatusResource(AttStatus::with(['team'])->get());
    }

    public function store(StoreAttStatusRequest $request)
    {
        $attStatus = AttStatus::create($request->all());

        return (new AttStatusResource($attStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttStatus $attStatus)
    {
        abort_if(Gate::denies('att_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttStatusResource($attStatus->load(['team']));
    }

    public function update(UpdateAttStatusRequest $request, AttStatus $attStatus)
    {
        $attStatus->update($request->all());

        return (new AttStatusResource($attStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttStatus $attStatus)
    {
        abort_if(Gate::denies('att_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
