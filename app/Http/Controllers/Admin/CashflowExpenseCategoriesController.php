<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCashflowExpenseCategoryRequest;
use App\Http\Requests\StoreCashflowExpenseCategoryRequest;
use App\Http\Requests\UpdateCashflowExpenseCategoryRequest;
use App\Models\CashflowExpenseCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CashflowExpenseCategoriesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cashflow_expense_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CashflowExpenseCategory::with(['team'])->select(sprintf('%s.*', (new CashflowExpenseCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cashflow_expense_category_show';
                $editGate = 'cashflow_expense_category_edit';
                $deleteGate = 'cashflow_expense_category_delete';
                $crudRoutePart = 'cashflow-expense-categories';

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

        return view('admin.cashflowExpenseCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cashflow_expense_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cashflowExpenseCategories.create');
    }

    public function store(StoreCashflowExpenseCategoryRequest $request)
    {
        $cashflowExpenseCategory = CashflowExpenseCategory::create($request->all());

        return redirect()->route('admin.cashflow-expense-categories.index');
    }

    public function edit(CashflowExpenseCategory $cashflowExpenseCategory)
    {
        abort_if(Gate::denies('cashflow_expense_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpenseCategory->load('team');

        return view('admin.cashflowExpenseCategories.edit', compact('cashflowExpenseCategory'));
    }

    public function update(UpdateCashflowExpenseCategoryRequest $request, CashflowExpenseCategory $cashflowExpenseCategory)
    {
        $cashflowExpenseCategory->update($request->all());

        return redirect()->route('admin.cashflow-expense-categories.index');
    }

    public function show(CashflowExpenseCategory $cashflowExpenseCategory)
    {
        abort_if(Gate::denies('cashflow_expense_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpenseCategory->load('team');

        return view('admin.cashflowExpenseCategories.show', compact('cashflowExpenseCategory'));
    }

    public function destroy(CashflowExpenseCategory $cashflowExpenseCategory)
    {
        abort_if(Gate::denies('cashflow_expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpenseCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyCashflowExpenseCategoryRequest $request)
    {
        CashflowExpenseCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
