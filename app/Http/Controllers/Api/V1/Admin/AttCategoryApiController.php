<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttCategoryRequest;
use App\Http\Requests\UpdateAttCategoryRequest;
use App\Http\Resources\Admin\AttCategoryResource;
use App\Models\AttCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttCategoryResource(AttCategory::with(['team'])->get());
    }

    public function store(StoreAttCategoryRequest $request)
    {
        $attCategory = AttCategory::create($request->all());

        return (new AttCategoryResource($attCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttCategory $attCategory)
    {
        abort_if(Gate::denies('att_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttCategoryResource($attCategory->load(['team']));
    }

    public function update(UpdateAttCategoryRequest $request, AttCategory $attCategory)
    {
        $attCategory->update($request->all());

        return (new AttCategoryResource($attCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttCategory $attCategory)
    {
        abort_if(Gate::denies('att_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
