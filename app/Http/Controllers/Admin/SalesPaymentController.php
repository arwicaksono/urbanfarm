<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySalesPaymentRequest;
use App\Http\Requests\StoreSalesPaymentRequest;
use App\Http\Requests\UpdateSalesPaymentRequest;
use App\Models\SalesPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesPaymentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sales_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SalesPayment::with(['team'])->select(sprintf('%s.*', (new SalesPayment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sales_payment_show';
                $editGate = 'sales_payment_edit';
                $deleteGate = 'sales_payment_delete';
                $crudRoutePart = 'sales-payments';

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
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.salesPayments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sales_payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.salesPayments.create');
    }

    public function store(StoreSalesPaymentRequest $request)
    {
        $salesPayment = SalesPayment::create($request->all());

        return redirect()->route('admin.sales-payments.index');
    }

    public function edit(SalesPayment $salesPayment)
    {
        abort_if(Gate::denies('sales_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesPayment->load('team');

        return view('admin.salesPayments.edit', compact('salesPayment'));
    }

    public function update(UpdateSalesPaymentRequest $request, SalesPayment $salesPayment)
    {
        $salesPayment->update($request->all());

        return redirect()->route('admin.sales-payments.index');
    }

    public function show(SalesPayment $salesPayment)
    {
        abort_if(Gate::denies('sales_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesPayment->load('team');

        return view('admin.salesPayments.show', compact('salesPayment'));
    }

    public function destroy(SalesPayment $salesPayment)
    {
        abort_if(Gate::denies('sales_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesPayment->delete();

        return back();
    }

    public function massDestroy(MassDestroySalesPaymentRequest $request)
    {
        SalesPayment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
