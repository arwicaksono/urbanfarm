<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductGradeRequest;
use App\Http\Requests\UpdateProductGradeRequest;
use App\Http\Resources\Admin\ProductGradeResource;
use App\Models\ProductGrade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductGradeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_grade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductGradeResource(ProductGrade::with(['team'])->get());
    }

    public function store(StoreProductGradeRequest $request)
    {
        $productGrade = ProductGrade::create($request->all());

        return (new ProductGradeResource($productGrade))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProductGrade $productGrade)
    {
        abort_if(Gate::denies('product_grade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductGradeResource($productGrade->load(['team']));
    }

    public function update(UpdateProductGradeRequest $request, ProductGrade $productGrade)
    {
        $productGrade->update($request->all());

        return (new ProductGradeResource($productGrade))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProductGrade $productGrade)
    {
        abort_if(Gate::denies('product_grade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productGrade->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
