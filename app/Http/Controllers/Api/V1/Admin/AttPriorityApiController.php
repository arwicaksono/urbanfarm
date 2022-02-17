<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttPriorityRequest;
use App\Http\Requests\UpdateAttPriorityRequest;
use App\Http\Resources\Admin\AttPriorityResource;
use App\Models\AttPriority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttPriorityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_priority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttPriorityResource(AttPriority::with(['team'])->get());
    }

    public function store(StoreAttPriorityRequest $request)
    {
        $attPriority = AttPriority::create($request->all());

        return (new AttPriorityResource($attPriority))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttPriority $attPriority)
    {
        abort_if(Gate::denies('att_priority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttPriorityResource($attPriority->load(['team']));
    }

    public function update(UpdateAttPriorityRequest $request, AttPriority $attPriority)
    {
        $attPriority->update($request->all());

        return (new AttPriorityResource($attPriority))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttPriority $attPriority)
    {
        abort_if(Gate::denies('att_priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attPriority->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
