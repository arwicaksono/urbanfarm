<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdminPlanRequest;
use App\Http\Requests\UpdateAdminPlanRequest;
use App\Http\Resources\Admin\AdminPlanResource;
use App\Models\AdminPlan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPlanApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminPlanResource(AdminPlan::all());
    }

    public function store(StoreAdminPlanRequest $request)
    {
        $adminPlan = AdminPlan::create($request->all());

        return (new AdminPlanResource($adminPlan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdminPlan $adminPlan)
    {
        abort_if(Gate::denies('admin_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdminPlanResource($adminPlan);
    }

    public function update(UpdateAdminPlanRequest $request, AdminPlan $adminPlan)
    {
        $adminPlan->update($request->all());

        return (new AdminPlanResource($adminPlan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdminPlan $adminPlan)
    {
        abort_if(Gate::denies('admin_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminPlan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
