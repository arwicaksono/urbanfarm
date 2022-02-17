<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdminExpertRequest;
use App\Http\Requests\UpdateAdminExpertRequest;
use App\Http\Resources\Admin\AdminExpertResource;
use App\Models\AdminExpert;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminExpertApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_expert_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminExpertResource(AdminExpert::all());
    }

    public function store(StoreAdminExpertRequest $request)
    {
        $adminExpert = AdminExpert::create($request->all());

        if ($request->input('image', false)) {
            $adminExpert->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new AdminExpertResource($adminExpert))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminExpert $adminExpert)
    {
        abort_if(Gate::denies('admin_expert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminExpertResource($adminExpert);
    }

    public function update(UpdateAdminExpertRequest $request, AdminExpert $adminExpert)
    {
        $adminExpert->update($request->all());

        if ($request->input('image', false)) {
            if (!$adminExpert->image || $request->input('image') !== $adminExpert->image->file_name) {
                if ($adminExpert->image) {
                    $adminExpert->image->delete();
                }
                $adminExpert->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($adminExpert->image) {
            $adminExpert->image->delete();
        }

        return (new AdminExpertResource($adminExpert))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminExpert $adminExpert)
    {
        abort_if(Gate::denies('admin_expert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminExpert->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
