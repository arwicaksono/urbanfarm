<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBusinessSettingRequest;
use App\Http\Requests\UpdateBusinessSettingRequest;
use App\Http\Resources\Admin\BusinessSettingResource;
use App\Models\BusinessSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessSettingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('business_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BusinessSettingResource(BusinessSetting::with(['team'])->get());
    }

    public function store(StoreBusinessSettingRequest $request)
    {
        $businessSetting = BusinessSetting::create($request->all());

        if ($request->input('logo', false)) {
            $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($request->input('banner', false)) {
            $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
        }

        return (new BusinessSettingResource($businessSetting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BusinessSetting $businessSetting)
    {
        abort_if(Gate::denies('business_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BusinessSettingResource($businessSetting->load(['team']));
    }

    public function update(UpdateBusinessSettingRequest $request, BusinessSetting $businessSetting)
    {
        $businessSetting->update($request->all());

        if ($request->input('logo', false)) {
            if (!$businessSetting->logo || $request->input('logo') !== $businessSetting->logo->file_name) {
                if ($businessSetting->logo) {
                    $businessSetting->logo->delete();
                }
                $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($businessSetting->logo) {
            $businessSetting->logo->delete();
        }

        if ($request->input('banner', false)) {
            if (!$businessSetting->banner || $request->input('banner') !== $businessSetting->banner->file_name) {
                if ($businessSetting->banner) {
                    $businessSetting->banner->delete();
                }
                $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
            }
        } elseif ($businessSetting->banner) {
            $businessSetting->banner->delete();
        }

        return (new BusinessSettingResource($businessSetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BusinessSetting $businessSetting)
    {
        abort_if(Gate::denies('business_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessSetting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
