<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdminPlanRequest;
use App\Http\Requests\StoreAdminPlanRequest;
use App\Http\Requests\UpdateAdminPlanRequest;
use App\Models\AdminPlan;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AdminPlanController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('admin_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminPlans = AdminPlan::all();

        return view('admin.adminPlans.index', compact('adminPlans'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminPlans.create');
    }

    public function store(StoreAdminPlanRequest $request)
    {
        $adminPlan = AdminPlan::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $adminPlan->id]);
        }

        return redirect()->route('admin.admin-plans.index');
    }

    public function edit(AdminPlan $adminPlan)
    {
        abort_if(Gate::denies('admin_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminPlans.edit', compact('adminPlan'));
    }

    public function update(UpdateAdminPlanRequest $request, AdminPlan $adminPlan)
    {
        $adminPlan->update($request->all());

        return redirect()->route('admin.admin-plans.index');
    }

    public function show(AdminPlan $adminPlan)
    {
        abort_if(Gate::denies('admin_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminPlans.show', compact('adminPlan'));
    }

    public function destroy(AdminPlan $adminPlan)
    {
        abort_if(Gate::denies('admin_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminPlan->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminPlanRequest $request)
    {
        AdminPlan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('admin_plan_create') && Gate::denies('admin_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AdminPlan();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
