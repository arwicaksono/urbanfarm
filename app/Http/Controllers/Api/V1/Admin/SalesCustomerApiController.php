<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSalesCustomerRequest;
use App\Http\Requests\UpdateSalesCustomerRequest;
use App\Http\Resources\Admin\SalesCustomerResource;
use App\Models\SalesCustomer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesCustomerApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('sales_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesCustomerResource(SalesCustomer::with(['status', 'categories', 'tags', 'team'])->get());
    }

    public function store(StoreSalesCustomerRequest $request)
    {
        $salesCustomer = SalesCustomer::create($request->all());
        $salesCustomer->categories()->sync($request->input('categories', []));
        $salesCustomer->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $salesCustomer->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new SalesCustomerResource($salesCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SalesCustomer $salesCustomer)
    {
        abort_if(Gate::denies('sales_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SalesCustomerResource($salesCustomer->load(['status', 'categories', 'tags', 'team']));
    }

    public function update(UpdateSalesCustomerRequest $request, SalesCustomer $salesCustomer)
    {
        $salesCustomer->update($request->all());
        $salesCustomer->categories()->sync($request->input('categories', []));
        $salesCustomer->tags()->sync($request->input('tags', []));
        if (count($salesCustomer->image) > 0) {
            foreach ($salesCustomer->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $salesCustomer->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $salesCustomer->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new SalesCustomerResource($salesCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SalesCustomer $salesCustomer)
    {
        abort_if(Gate::denies('sales_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesCustomer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
