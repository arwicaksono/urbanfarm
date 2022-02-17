<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdminInfoRequest;
use App\Http\Requests\StoreAdminInfoRequest;
use App\Http\Requests\UpdateAdminInfoRequest;
use App\Models\AdminInfo;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AdminInfoController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminInfos = AdminInfo::with(['media'])->get();

        return view('admin.adminInfos.index', compact('adminInfos'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_info_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminInfos.create');
    }

    public function store(StoreAdminInfoRequest $request)
    {
        $adminInfo = AdminInfo::create($request->all());

        if ($request->input('image', false)) {
            $adminInfo->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $adminInfo->id]);
        }

        return redirect()->route('admin.admin-infos.index');
    }

    public function edit(AdminInfo $adminInfo)
    {
        abort_if(Gate::denies('admin_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminInfos.edit', compact('adminInfo'));
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

        return redirect()->route('admin.admin-infos.index');
    }

    public function show(AdminInfo $adminInfo)
    {
        abort_if(Gate::denies('admin_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminInfos.show', compact('adminInfo'));
    }

    public function destroy(AdminInfo $adminInfo)
    {
        abort_if(Gate::denies('admin_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminInfo->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminInfoRequest $request)
    {
        AdminInfo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('admin_info_create') && Gate::denies('admin_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AdminInfo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
