<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesPaymentRequest;
use App\Http\Requests\UpdateSalesPaymentRequest;
use App\Http\Resources\Admin\SalesPaymentResource;
use App\Models\SalesPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesPaymentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sales_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesPaymentResource(SalesPayment::with(['team'])->get());
    }

    public function store(StoreSalesPaymentRequest $request)
    {
        $salesPayment = SalesPayment::create($request->all());

        return (new SalesPaymentResource($salesPayment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SalesPayment $salesPayment)
    {
        abort_if(Gate::denies('sales_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesPaymentResource($salesPayment->load(['team']));
    }

    public function update(UpdateSalesPaymentRequest $request, SalesPayment $salesPayment)
    {
        $salesPayment->update($request->all());

        return (new SalesPaymentResource($salesPayment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SalesPayment $salesPayment)
    {
        abort_if(Gate::denies('sales_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesPayment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
