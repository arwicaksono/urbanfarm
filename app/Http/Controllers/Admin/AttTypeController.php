<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttTypeRequest;
use App\Http\Requests\StoreAttTypeRequest;
use App\Http\Requests\UpdateAttTypeRequest;
use App\Models\AttType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttTypeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttType::with(['team'])->select(sprintf('%s.*', (new AttType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_type_show';
                $editGate = 'att_type_edit';
                $deleteGate = 'att_type_delete';
                $crudRoutePart = 'att-types';

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

        return view('admin.attTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attTypes.create');
    }

    public function store(StoreAttTypeRequest $request)
    {
        $attType = AttType::create($request->all());

        return redirect()->route('admin.att-types.index');
    }

    public function edit(AttType $attType)
    {
        abort_if(Gate::denies('att_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attType->load('team');

        return view('admin.attTypes.edit', compact('attType'));
    }

    public function update(UpdateAttTypeRequest $request, AttType $attType)
    {
        $attType->update($request->all());

        return redirect()->route('admin.att-types.index');
    }

    public function show(AttType $attType)
    {
        abort_if(Gate::denies('att_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attType->load('team');

        return view('admin.attTypes.show', compact('attType'));
    }

    public function destroy(AttType $attType)
    {
        abort_if(Gate::denies('att_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attType->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttTypeRequest $request)
    {
        AttType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
