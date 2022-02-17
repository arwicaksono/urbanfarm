<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySalesLabelRequest;
use App\Http\Requests\StoreSalesLabelRequest;
use App\Http\Requests\UpdateSalesLabelRequest;
use App\Models\PurchaseCompany;
use App\Models\SalesLabel;
use App\Models\UnitQuantity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesLabelController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sales_label_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SalesLabel::with(['unit', 'companies', 'team'])->select(sprintf('%s.*', (new SalesLabel())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sales_label_show';
                $editGate = 'sales_label_edit';
                $deleteGate = 'sales_label_delete';
                $crudRoutePart = 'sales-labels';

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
            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
            });

            $table->editColumn('company', function ($row) {
                $labels = [];
                foreach ($row->companies as $company) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $company->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'unit', 'company']);

            return $table->make(true);
        }

        return view('admin.salesLabels.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sales_label_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = PurchaseCompany::pluck('name', 'id');

        return view('admin.salesLabels.create', compact('companies', 'units'));
    }

    public function store(StoreSalesLabelRequest $request)
    {
        $salesLabel = SalesLabel::create($request->all());
        $salesLabel->companies()->sync($request->input('companies', []));

        return redirect()->route('admin.sales-labels.index');
    }

    public function edit(SalesLabel $salesLabel)
    {
        abort_if(Gate::denies('sales_label_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = PurchaseCompany::pluck('name', 'id');

        $salesLabel->load('unit', 'companies', 'team');

        return view('admin.salesLabels.edit', compact('companies', 'salesLabel', 'units'));
    }

    public function update(UpdateSalesLabelRequest $request, SalesLabel $salesLabel)
    {
        $salesLabel->update($request->all());
        $salesLabel->companies()->sync($request->input('companies', []));

        return redirect()->route('admin.sales-labels.index');
    }

    public function show(SalesLabel $salesLabel)
    {
        abort_if(Gate::denies('sales_label_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesLabel->load('unit', 'companies', 'team');

        return view('admin.salesLabels.show', compact('salesLabel'));
    }

    public function destroy(SalesLabel $salesLabel)
    {
        abort_if(Gate::denies('sales_label_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesLabel->delete();

        return back();
    }

    public function massDestroy(MassDestroySalesLabelRequest $request)
    {
        SalesLabel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
