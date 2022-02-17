<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdminInfoRequest;
use App\Http\Requests\UpdateAdminInfoRequest;
use App\Http\Resources\Admin\AdminInfoResource;
use App\Models\AdminInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminInfoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminInfoResource(AdminInfo::all());
    }

    public function store(StoreAdminInfoRequest $request)
    {
        $adminInfo = AdminInfo::create($request->all());

        if ($request->input('image', false)) {
            $adminInfo->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new AdminInfoResource($adminInfo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminInfo $adminInfo)
    {
        abort_if(Gate::denies('admin_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminInfoResource($adminInfo);
    }

    public function update(UpdateAdminInfoRequest $request, AdminInfo $adminInfo)
    {
        $adminInfo->update($request->all());

        if ($request->input('image', false)) {
            if (!$adminInfo->image || $request->input('image') !== $adminInfo->image->file_name) {
                if ($adminInfo->image) {
                    $adminInfo->image->delete();
                }
                $adminInfo->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($adminInfo->image) {
            $adminInfo->image->delete();
        }

        return (new AdminInfoResource($adminInfo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminInfo $adminInfo)
    {
        abort_if(Gate::denies('admin_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminInfo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
