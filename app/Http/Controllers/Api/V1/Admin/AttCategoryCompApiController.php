<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttCategoryCompRequest;
use App\Http\Requests\UpdateAttCategoryCompRequest;
use App\Http\Resources\Admin\AttCategoryCompResource;
use App\Models\AttCategoryComp;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttCategoryCompApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('att_category_comp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttCategoryCompResource(AttCategoryComp::with(['team'])->get());
    }

    public function store(StoreAttCategoryCompRequest $request)
    {
        $attCategoryComp = AttCategoryComp::create($request->all());

        return (new AttCategoryCompResource($attCategoryComp))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttCategoryComp $attCategoryComp)
    {
        abort_if(Gate::denies('att_category_comp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttCategoryCompResource($attCategoryComp->load(['team']));
    }

    public function update(UpdateAttCategoryCompRequest $request, AttCategoryComp $attCategoryComp)
    {
        $attCategoryComp->update($request->all());

        return (new AttCategoryCompResource($attCategoryComp))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttCategoryComp $attCategoryComp)
    {
        abort_if(Gate::denies('att_category_comp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategoryComp->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
