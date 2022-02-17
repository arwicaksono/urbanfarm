<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttCategoryCompRequest;
use App\Http\Requests\StoreAttCategoryCompRequest;
use App\Http\Requests\UpdateAttCategoryCompRequest;
use App\Models\AttCategoryComp;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttCategoryCompController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_category_comp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttCategoryComp::with(['team'])->select(sprintf('%s.*', (new AttCategoryComp())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_category_comp_show';
                $editGate = 'att_category_comp_edit';
                $deleteGate = 'att_category_comp_delete';
                $crudRoutePart = 'att-category-comps';

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

        return view('admin.attCategoryComps.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_category_comp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attCategoryComps.create');
    }

    public function store(StoreAttCategoryCompRequest $request)
    {
        $attCategoryComp = AttCategoryComp::create($request->all());

        return redirect()->route('admin.att-category-comps.index');
    }

    public function edit(AttCategoryComp $attCategoryComp)
    {
        abort_if(Gate::denies('att_category_comp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategoryComp->load('team');

        return view('admin.attCategoryComps.edit', compact('attCategoryComp'));
    }

    public function update(UpdateAttCategoryCompRequest $request, AttCategoryComp $attCategoryComp)
    {
        $attCategoryComp->update($request->all());

        return redirect()->route('admin.att-category-comps.index');
    }

    public function show(AttCategoryComp $attCategoryComp)
    {
        abort_if(Gate::denies('att_category_comp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategoryComp->load('team');

        return view('admin.attCategoryComps.show', compact('attCategoryComp'));
    }

    public function destroy(AttCategoryComp $attCategoryComp)
    {
        abort_if(Gate::denies('att_category_comp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategoryComp->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttCategoryCompRequest $request)
    {
        AttCategoryComp::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
