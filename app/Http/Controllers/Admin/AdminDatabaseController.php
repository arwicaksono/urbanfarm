<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdminDatabaseRequest;
use App\Http\Requests\StoreAdminDatabaseRequest;
use App\Http\Requests\UpdateAdminDatabaseRequest;
use App\Models\AdminDatabase;
use App\Models\AdminTag;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AdminDatabaseController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_database_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminDatabases = AdminDatabase::with(['tags', 'media'])->get();

        return view('admin.adminDatabases.index', compact('adminDatabases'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_database_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = AdminTag::pluck('name', 'id');

        return view('admin.adminDatabases.create', compact('tags'));
    }

    public function store(StoreAdminDatabaseRequest $request)
    {
        $adminDatabase = AdminDatabase::create($request->all());
        $adminDatabase->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $adminDatabase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $adminDatabase->id]);
        }

        return redirect()->route('admin.admin-databases.index');
    }

    public function edit(AdminDatabase $adminDatabase)
    {
        abort_if(Gate::denies('admin_database_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = AdminTag::pluck('name', 'id');

        $adminDatabase->load('tags');

        return view('admin.adminDatabases.edit', compact('adminDatabase', 'tags'));
    }

    public function update(UpdateAdminDatabaseRequest $request, AdminDatabase $adminDatabase)
    {
        $adminDatabase->update($request->all());
        $adminDatabase->tags()->sync($request->input('tags', []));
        if (count($adminDatabase->image) > 0) {
            foreach ($adminDatabase->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $adminDatabase->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $adminDatabase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.admin-databases.index');
    }

    public function show(AdminDatabase $adminDatabase)
    {
        abort_if(Gate::denies('admin_database_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminDatabase->load('tags');

        return view('admin.adminDatabases.show', compact('adminDatabase'));
    }

    public function destroy(AdminDatabase $adminDatabase)
    {
        abort_if(Gate::denies('admin_database_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminDatabase->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminDatabaseRequest $request)
    {
        AdminDatabase::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('admin_database_create') && Gate::denies('admin_database_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AdminDatabase();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
