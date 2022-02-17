<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttEfficacyRequest;
use App\Http\Requests\UpdateAttEfficacyRequest;
use App\Http\Resources\Admin\AttEfficacyResource;
use App\Models\AttEfficacy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttEfficacyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_efficacy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttEfficacyResource(AttEfficacy::with(['team'])->get());
    }

    public function store(StoreAttEfficacyRequest $request)
    {
        $attEfficacy = AttEfficacy::create($request->all());

        return (new AttEfficacyResource($attEfficacy))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttEfficacy $attEfficacy)
    {
        abort_if(Gate::denies('att_efficacy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttEfficacyResource($attEfficacy->load(['team']));
    }

    public function update(UpdateAttEfficacyRequest $request, AttEfficacy $attEfficacy)
    {
        $attEfficacy->update($request->all());

        return (new AttEfficacyResource($attEfficacy))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttEfficacy $attEfficacy)
    {
        abort_if(Gate::denies('att_efficacy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attEfficacy->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
