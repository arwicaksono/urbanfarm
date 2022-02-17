<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSalesMarketRequest;
use App\Http\Requests\UpdateSalesMarketRequest;
use App\Http\Resources\Admin\SalesMarketResource;
use App\Models\SalesMarket;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesMarketApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('sales_market_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesMarketResource(SalesMarket::with(['channel', 'payment', 'tags', 'team'])->get());
    }

    public function store(StoreSalesMarketRequest $request)
    {
        $salesMarket = SalesMarket::create($request->all());
        $salesMarket->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $salesMarket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new SalesMarketResource($salesMarket))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SalesMarket $salesMarket)
    {
        abort_if(Gate::denies('sales_market_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesMarketResource($salesMarket->load(['channel', 'payment', 'tags', 'team']));
    }

    public function update(UpdateSalesMarketRequest $request, SalesMarket $salesMarket)
    {
        $salesMarket->update($request->all());
        $salesMarket->tags()->sync($request->input('tags', []));
        if (count($salesMarket->image) > 0) {
            foreach ($salesMarket->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $salesMarket->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $salesMarket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new SalesMarketResource($salesMarket))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SalesMarket $salesMarket)
    {
        abort_if(Gate::denies('sales_market_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesMarket->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
