<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttStatusRequest;
use App\Http\Requests\StoreAttStatusRequest;
use App\Http\Requests\UpdateAttStatusRequest;
use App\Models\AttStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttStatusController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttStatus::with(['team'])->select(sprintf('%s.*', (new AttStatus())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_status_show';
                $editGate = 'att_status_edit';
                $deleteGate = 'att_status_delete';
                $crudRoutePart = 'att-statuses';

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
            $table->editColumn('group', function ($row) {
                return $row->group ? $row->group : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.attStatuses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attStatuses.create');
    }

    public function store(StoreAttStatusRequest $request)
    {
        $attStatus = AttStatus::create($request->all());

        return redirect()->route('admin.att-statuses.index');
    }

    public function edit(AttStatus $attStatus)
    {
        abort_if(Gate::denies('att_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attStatus->load('team');

        return view('admin.attStatuses.edit', compact('attStatus'));
    }

    public function update(UpdateAttStatusRequest $request, AttStatus $attStatus)
    {
        $attStatus->update($request->all());

        return redirect()->route('admin.att-statuses.index');
    }

    public function show(AttStatus $attStatus)
    {
        abort_if(Gate::denies('att_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attStatus->load('team');

        return view('admin.attStatuses.show', compact('attStatus'));
    }

    public function destroy(AttStatus $attStatus)
    {
        abort_if(Gate::denies('att_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttStatusRequest $request)
    {
        AttStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
