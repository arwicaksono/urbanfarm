<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCashflowIncomeCategoryRequest;
use App\Http\Requests\StoreCashflowIncomeCategoryRequest;
use App\Http\Requests\UpdateCashflowIncomeCategoryRequest;
use App\Models\CashflowIncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CashflowIncomeCategoryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cashflow_income_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CashflowIncomeCategory::with(['team'])->select(sprintf('%s.*', (new CashflowIncomeCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cashflow_income_category_show';
                $editGate = 'cashflow_income_category_edit';
                $deleteGate = 'cashflow_income_category_delete';
                $crudRoutePart = 'cashflow-income-categories';

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

        return view('admin.cashflowIncomeCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cashflow_income_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cashflowIncomeCategories.create');
    }

    public function store(StoreCashflowIncomeCategoryRequest $request)
    {
        $cashflowIncomeCategory = CashflowIncomeCategory::create($request->all());

        return redirect()->route('admin.cashflow-income-categories.index');
    }

    public function edit(CashflowIncomeCategory $cashflowIncomeCategory)
    {
        abort_if(Gate::denies('cashflow_income_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncomeCategory->load('team');

        return view('admin.cashflowIncomeCategories.edit', compact('cashflowIncomeCategory'));
    }

    public function update(UpdateCashflowIncomeCategoryRequest $request, CashflowIncomeCategory $cashflowIncomeCategory)
    {
        $cashflowIncomeCategory->update($request->all());

        return redirect()->route('admin.cashflow-income-categories.index');
    }

    public function show(CashflowIncomeCategory $cashflowIncomeCategory)
    {
        abort_if(Gate::denies('cashflow_income_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncomeCategory->load('team');

        return view('admin.cashflowIncomeCategories.show', compact('cashflowIncomeCategory'));
    }

    public function destroy(CashflowIncomeCategory $cashflowIncomeCategory)
    {
        abort_if(Gate::denies('cashflow_income_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncomeCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyCashflowIncomeCategoryRequest $request)
    {
        CashflowIncomeCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
