<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesChannelRequest;
use App\Http\Requests\UpdateSalesChannelRequest;
use App\Http\Resources\Admin\SalesChannelResource;
use App\Models\SalesChannel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesChannelApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sales_channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesChannelResource(SalesChannel::with(['team'])->get());
    }

    public function store(StoreSalesChannelRequest $request)
    {
        $salesChannel = SalesChannel::create($request->all());

        return (new SalesChannelResource($salesChannel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SalesChannel $salesChannel)
    {
        abort_if(Gate::denies('sales_channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesChannelResource($salesChannel->load(['team']));
    }

    public function update(UpdateSalesChannelRequest $request, SalesChannel $salesChannel)
    {
        $salesChannel->update($request->all());

        return (new SalesChannelResource($salesChannel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SalesChannel $salesChannel)
    {
        abort_if(Gate::denies('sales_channel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesChannel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
