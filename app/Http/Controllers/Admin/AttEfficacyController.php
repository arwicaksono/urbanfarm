<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttEfficacyRequest;
use App\Http\Requests\StoreAttEfficacyRequest;
use App\Http\Requests\UpdateAttEfficacyRequest;
use App\Models\AttEfficacy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttEfficacyController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_efficacy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttEfficacy::with(['team'])->select(sprintf('%s.*', (new AttEfficacy())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_efficacy_show';
                $editGate = 'att_efficacy_edit';
                $deleteGate = 'att_efficacy_delete';
                $crudRoutePart = 'att-efficacies';

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

        return view('admin.attEfficacies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_efficacy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attEfficacies.create');
    }

    public function store(StoreAttEfficacyRequest $request)
    {
        $attEfficacy = AttEfficacy::create($request->all());

        return redirect()->route('admin.att-efficacies.index');
    }

    public function edit(AttEfficacy $attEfficacy)
    {
        abort_if(Gate::denies('att_efficacy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attEfficacy->load('team');

        return view('admin.attEfficacies.edit', compact('attEfficacy'));
    }

    public function update(UpdateAttEfficacyRequest $request, AttEfficacy $attEfficacy)
    {
        $attEfficacy->update($request->all());

        return redirect()->route('admin.att-efficacies.index');
    }

    public function show(AttEfficacy $attEfficacy)
    {
        abort_if(Gate::denies('att_efficacy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attEfficacy->load('team');

        return view('admin.attEfficacies.show', compact('attEfficacy'));
    }

    public function destroy(AttEfficacy $attEfficacy)
    {
        abort_if(Gate::denies('att_efficacy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attEfficacy->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttEfficacyRequest $request)
    {
        AttEfficacy::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
