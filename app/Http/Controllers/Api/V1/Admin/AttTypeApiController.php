<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttTypeRequest;
use App\Http\Requests\UpdateAttTypeRequest;
use App\Http\Resources\Admin\AttTypeResource;
use App\Models\AttType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttTypeResource(AttType::with(['team'])->get());
    }

    public function store(StoreAttTypeRequest $request)
    {
        $attType = AttType::create($request->all());

        return (new AttTypeResource($attType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttType $attType)
    {
        abort_if(Gate::denies('att_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttTypeResource($attType->load(['team']));
    }

    public function update(UpdateAttTypeRequest $request, AttType $attType)
    {
        $attType->update($request->all());

        return (new AttTypeResource($attType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttType $attType)
    {
        abort_if(Gate::denies('att_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
