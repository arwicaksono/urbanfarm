<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProductGradeRequest;
use App\Http\Requests\StoreProductGradeRequest;
use App\Http\Requests\UpdateProductGradeRequest;
use App\Models\ProductGrade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductGradeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_grade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProductGrade::with(['team'])->select(sprintf('%s.*', (new ProductGrade())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'product_grade_show';
                $editGate = 'product_grade_edit';
                $deleteGate = 'product_grade_delete';
                $crudRoutePart = 'product-grades';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.productGrades.index');
    }

    public function create()
    {
        abort_if(Gate::denies('product_grade_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productGrades.create');
    }

    public function store(StoreProductGradeRequest $request)
    {
        $productGrade = ProductGrade::create($request->all());

        return redirect()->route('admin.product-grades.index');
    }

    public function edit(ProductGrade $productGrade)
    {
        abort_if(Gate::denies('product_grade_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productGrade->load('team');

        return view('admin.productGrades.edit', compact('productGrade'));
    }

    public function update(UpdateProductGradeRequest $request, ProductGrade $productGrade)
    {
        $productGrade->update($request->all());

        return redirect()->route('admin.product-grades.index');
    }

    public function show(ProductGrade $productGrade)
    {
        abort_if(Gate::denies('product_grade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productGrade->load('team');

        return view('admin.productGrades.show', compact('productGrade'));
    }

    public function destroy(ProductGrade $productGrade)
    {
        abort_if(Gate::denies('product_grade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productGrade->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductGradeRequest $request)
    {
        ProductGrade::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
