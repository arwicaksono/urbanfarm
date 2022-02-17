<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdminCategoryRequest;
use App\Http\Requests\UpdateAdminCategoryRequest;
use App\Http\Resources\Admin\AdminCategoryResource;
use App\Models\AdminCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCategoryApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminCategoryResource(AdminCategory::all());
    }

    public function store(StoreAdminCategoryRequest $request)
    {
        $adminCategory = AdminCategory::create($request->all());

        if ($request->input('image', false)) {
            $adminCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new AdminCategoryResource($adminCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminCategory $adminCategory)
    {
        abort_if(Gate::denies('admin_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminCategoryResource($adminCategory);
    }

    public function update(UpdateAdminCategoryRequest $request, AdminCategory $adminCategory)
    {
        $adminCategory->update($request->all());

        if ($request->input('image', false)) {
            if (!$adminCategory->image || $request->input('image') !== $adminCategory->image->file_name) {
                if ($adminCategory->image) {
                    $adminCategory->image->delete();
                }
                $adminCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($adminCategory->image) {
            $adminCategory->image->delete();
        }

        return (new AdminCategoryResource($adminCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminCategory $adminCategory)
    {
        abort_if(Gate::denies('admin_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
