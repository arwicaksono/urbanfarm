<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCareSaleRequest;
use App\Http\Requests\UpdateCareSaleRequest;
use App\Http\Resources\Admin\CareSaleResource;
use App\Models\CareSale;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareSaleApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('care_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareSaleResource(CareSale::with(['problem_sale', 'status', 'tags', 'person_in_charges', 'team'])->get());
    }

    public function store(StoreCareSaleRequest $request)
    {
        $careSale = CareSale::create($request->all());
        $careSale->tags()->sync($request->input('tags', []));
        $careSale->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $careSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        return (new CareSaleResource($careSale))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CareSale $careSale)
    {
        abort_if(Gate::denies('care_sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CareSaleResource($careSale->load(['problem_sale', 'status', 'tags', 'person_in_charges', 'team']));
    }

    public function update(UpdateCareSaleRequest $request, CareSale $careSale)
    {
        $careSale->update($request->all());
        $careSale->tags()->sync($request->input('tags', []));
        $careSale->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($careSale->image) > 0) {
            foreach ($careSale->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $careSale->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $careSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return (new CareSaleResource($careSale))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CareSale $careSale)
    {
        abort_if(Gate::denies('care_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careSale->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
