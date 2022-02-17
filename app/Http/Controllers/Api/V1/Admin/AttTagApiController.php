<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttTagRequest;
use App\Http\Requests\UpdateAttTagRequest;
use App\Http\Resources\Admin\AttTagResource;
use App\Models\AttTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttTagApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttTagResource(AttTag::with(['team'])->get());
    }

    public function store(StoreAttTagRequest $request)
    {
        $attTag = AttTag::create($request->all());

        return (new AttTagResource($attTag))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttTag $attTag)
    {
        abort_if(Gate::denies('att_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttTagResource($attTag->load(['team']));
    }

    public function update(UpdateAttTagRequest $request, AttTag $attTag)
    {
        $attTag->update($request->all());

        return (new AttTagResource($attTag))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttTag $attTag)
    {
        abort_if(Gate::denies('att_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attTag->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
