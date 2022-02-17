<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttPriorityRequest;
use App\Http\Requests\StoreAttPriorityRequest;
use App\Http\Requests\UpdateAttPriorityRequest;
use App\Models\AttPriority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttPriorityController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_priority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttPriority::with(['team'])->select(sprintf('%s.*', (new AttPriority())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_priority_show';
                $editGate = 'att_priority_edit';
                $deleteGate = 'att_priority_delete';
                $crudRoutePart = 'att-priorities';

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

        return view('admin.attPriorities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_priority_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attPriorities.create');
    }

    public function store(StoreAttPriorityRequest $request)
    {
        $attPriority = AttPriority::create($request->all());

        return redirect()->route('admin.att-priorities.index');
    }

    public function edit(AttPriority $attPriority)
    {
        abort_if(Gate::denies('att_priority_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attPriority->load('team');

        return view('admin.attPriorities.edit', compact('attPriority'));
    }

    public function update(UpdateAttPriorityRequest $request, AttPriority $attPriority)
    {
        $attPriority->update($request->all());

        return redirect()->route('admin.att-priorities.index');
    }

    public function show(AttPriority $attPriority)
    {
        abort_if(Gate::denies('att_priority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attPriority->load('team');

        return view('admin.attPriorities.show', compact('attPriority'));
    }

    public function destroy(AttPriority $attPriority)
    {
        abort_if(Gate::denies('att_priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attPriority->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttPriorityRequest $request)
    {
        AttPriority::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
