<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySalesChannelRequest;
use App\Http\Requests\StoreSalesChannelRequest;
use App\Http\Requests\UpdateSalesChannelRequest;
use App\Models\SalesChannel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesChannelController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sales_channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SalesChannel::with(['team'])->select(sprintf('%s.*', (new SalesChannel())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sales_channel_show';
                $editGate = 'sales_channel_edit';
                $deleteGate = 'sales_channel_delete';
                $crudRoutePart = 'sales-channels';

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
            $table->editColumn('sales_type', function ($row) {
                return $row->sales_type ? SalesChannel::SALES_TYPE_SELECT[$row->sales_type] : '';
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.salesChannels.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sales_channel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.salesChannels.create');
    }

    public function store(StoreSalesChannelRequest $request)
    {
        $salesChannel = SalesChannel::create($request->all());

        return redirect()->route('admin.sales-channels.index');
    }

    public function edit(SalesChannel $salesChannel)
    {
        abort_if(Gate::denies('sales_channel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesChannel->load('team');

        return view('admin.salesChannels.edit', compact('salesChannel'));
    }

    public function update(UpdateSalesChannelRequest $request, SalesChannel $salesChannel)
    {
        $salesChannel->update($request->all());

        return redirect()->route('admin.sales-channels.index');
    }

    public function show(SalesChannel $salesChannel)
    {
        abort_if(Gate::denies('sales_channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesChannel->load('team');

        return view('admin.salesChannels.show', compact('salesChannel'));
    }

    public function destroy(SalesChannel $salesChannel)
    {
        abort_if(Gate::denies('sales_channel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesChannel->delete();

        return back();
    }

    public function massDestroy(MassDestroySalesChannelRequest $request)
    {
        SalesChannel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
