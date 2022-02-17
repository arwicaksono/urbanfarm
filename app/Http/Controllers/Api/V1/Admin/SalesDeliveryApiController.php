<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesDeliveryRequest;
use App\Http\Requests\UpdateSalesDeliveryRequest;
use App\Http\Resources\Admin\SalesDeliveryResource;
use App\Models\SalesDelivery;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesDeliveryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sales_delivery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesDeliveryResource(SalesDelivery::with(['team'])->get());
    }

    public function store(StoreSalesDeliveryRequest $request)
    {
        $salesDelivery = SalesDelivery::create($request->all());

        return (new SalesDeliveryResource($salesDelivery))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SalesDelivery $salesDelivery)
    {
        abort_if(Gate::denies('sales_delivery_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesDeliveryResource($salesDelivery->load(['team']));
    }

    public function update(UpdateSalesDeliveryRequest $request, SalesDelivery $salesDelivery)
    {
        $salesDelivery->update($request->all());

        return (new SalesDeliveryResource($salesDelivery))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SalesDelivery $salesDelivery)
    {
        abort_if(Gate::denies('sales_delivery_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesDelivery->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
