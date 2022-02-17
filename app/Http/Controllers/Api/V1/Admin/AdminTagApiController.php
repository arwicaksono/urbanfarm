<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminTagRequest;
use App\Http\Requests\UpdateAdminTagRequest;
use App\Http\Resources\Admin\AdminTagResource;
use App\Models\AdminTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTagApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('admin_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminTagResource(AdminTag::all());
    }

    public function store(StoreAdminTagRequest $request)
    {
        $adminTag = AdminTag::create($request->all());

        return (new AdminTagResource($adminTag))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminTag $adminTag)
    {
        abort_if(Gate::denies('admin_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminTagResource($adminTag);
    }

    public function update(UpdateAdminTagRequest $request, AdminTag $adminTag)
    {
        $adminTag->update($request->all());

        return (new AdminTagResource($adminTag))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminTag $adminTag)
    {
        abort_if(Gate::denies('admin_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminTag->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
