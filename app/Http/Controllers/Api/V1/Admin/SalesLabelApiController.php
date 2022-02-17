<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesLabelRequest;
use App\Http\Requests\UpdateSalesLabelRequest;
use App\Http\Resources\Admin\SalesLabelResource;
use App\Models\SalesLabel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesLabelApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sales_label_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesLabelResource(SalesLabel::with(['unit', 'companies', 'team'])->get());
    }

    public function store(StoreSalesLabelRequest $request)
    {
        $salesLabel = SalesLabel::create($request->all());
        $salesLabel->companies()->sync($request->input('companies', []));

        return (new SalesLabelResource($salesLabel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SalesLabel $salesLabel)
    {
        abort_if(Gate::denies('sales_label_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesLabelResource($salesLabel->load(['unit', 'companies', 'team']));
    }

    public function update(UpdateSalesLabelRequest $request, SalesLabel $salesLabel)
    {
        $salesLabel->update($request->all());
        $salesLabel->companies()->sync($request->input('companies', []));

        return (new SalesLabelResource($salesLabel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SalesLabel $salesLabel)
    {
        abort_if(Gate::denies('sales_label_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesLabel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
