<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySalesDeliveryRequest;
use App\Http\Requests\StoreSalesDeliveryRequest;
use App\Http\Requests\UpdateSalesDeliveryRequest;
use App\Models\SalesDelivery;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesDeliveryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sales_delivery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SalesDelivery::with(['team'])->select(sprintf('%s.*', (new SalesDelivery())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sales_delivery_show';
                $editGate = 'sales_delivery_edit';
                $deleteGate = 'sales_delivery_delete';
                $crudRoutePart = 'sales-deliveries';

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
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('contact', function ($row) {
                return $row->contact ? $row->contact : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.salesDeliveries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sales_delivery_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.salesDeliveries.create');
    }

    public function store(StoreSalesDeliveryRequest $request)
    {
        $salesDelivery = SalesDelivery::create($request->all());

        return redirect()->route('admin.sales-deliveries.index');
    }

    public function edit(SalesDelivery $salesDelivery)
    {
        abort_if(Gate::denies('sales_delivery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesDelivery->load('team');

        return view('admin.salesDeliveries.edit', compact('salesDelivery'));
    }

    public function update(UpdateSalesDeliveryRequest $request, SalesDelivery $salesDelivery)
    {
        $salesDelivery->update($request->all());

        return redirect()->route('admin.sales-deliveries.index');
    }

    public function show(SalesDelivery $salesDelivery)
    {
        abort_if(Gate::denies('sales_delivery_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesDelivery->load('team');

        return view('admin.salesDeliveries.show', compact('salesDelivery'));
    }

    public function destroy(SalesDelivery $salesDelivery)
    {
        abort_if(Gate::denies('sales_delivery_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesDelivery->delete();

        return back();
    }

    public function massDestroy(MassDestroySalesDeliveryRequest $request)
    {
        SalesDelivery::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
