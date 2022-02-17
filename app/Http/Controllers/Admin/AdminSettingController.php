<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdminSettingRequest;
use App\Http\Requests\StoreAdminSettingRequest;
use App\Http\Requests\UpdateAdminSettingRequest;
use App\Models\AdminSetting;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AdminSettingController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminSettings = AdminSetting::with(['media'])->get();

        return view('admin.adminSettings.index', compact('adminSettings'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminSettings.create');
    }

    public function store(StoreAdminSettingRequest $request)
    {
        $adminSetting = AdminSetting::create($request->all());

        if ($request->input('logo', false)) {
            $adminSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $adminSetting->id]);
        }

        return redirect()->route('admin.admin-settings.index');
    }

    public function edit(AdminSetting $adminSetting)
    {
        abort_if(Gate::denies('admin_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminSettings.edit', compact('adminSetting'));
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

        return redirect()->route('admin.admin-settings.index');
    }

    public function show(AdminSetting $adminSetting)
    {
        abort_if(Gate::denies('admin_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminSettings.show', compact('adminSetting'));
    }

    public function destroy(AdminSetting $adminSetting)
    {
        abort_if(Gate::denies('admin_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminSettingRequest $request)
    {
        AdminSetting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('admin_setting_create') && Gate::denies('admin_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AdminSetting();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
