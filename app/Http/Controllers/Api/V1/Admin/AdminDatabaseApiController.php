<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdminDatabaseRequest;
use App\Http\Requests\UpdateAdminDatabaseRequest;
use App\Http\Resources\Admin\AdminDatabaseResource;
use App\Models\AdminDatabase;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDatabaseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_database_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminDatabaseResource(AdminDatabase::with(['tags'])->get());
    }

    public function store(StoreAdminDatabaseRequest $request)
    {
        $adminDatabase = AdminDatabase::create($request->all());
        $adminDatabase->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $adminDatabase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new AdminDatabaseResource($adminDatabase))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminDatabase $adminDatabase)
    {
        abort_if(Gate::denies('admin_database_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminDatabaseResource($adminDatabase->load(['tags']));
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

        return (new AdminDatabaseResource($adminDatabase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminDatabase $adminDatabase)
    {
        abort_if(Gate::denies('admin_database_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminDatabase->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
