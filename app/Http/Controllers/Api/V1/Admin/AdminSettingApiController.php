<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdminSettingRequest;
use App\Http\Requests\UpdateAdminSettingRequest;
use App\Http\Resources\Admin\AdminSettingResource;
use App\Models\AdminSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSettingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminSettingResource(AdminSetting::all());
    }

    public function store(StoreAdminSettingRequest $request)
    {
        $adminSetting = AdminSetting::create($request->all());

        if ($request->input('logo', false)) {
            $adminSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        return (new AdminSettingResource($adminSetting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminSetting $adminSetting)
    {
        abort_if(Gate::denies('admin_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminSettingResource($adminSetting);
    }

    public function update(UpdateAdminSettingRequest $request, AdminSetting $adminSetting)
    {
        $adminSetting->update($request->all());

        if ($request->input('logo', false)) {
            if (!$adminSetting->logo || $request->input('logo') !== $adminSetting->logo->file_name) {
                if ($adminSetting->logo) {
                    $adminSetting->logo->delete();
                }
                $adminSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($adminSetting->logo) {
            $adminSetting->logo->delete();
        }

        return (new AdminSettingResource($adminSetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminSetting $adminSetting)
    {
        abort_if(Gate::denies('admin_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminSetting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
