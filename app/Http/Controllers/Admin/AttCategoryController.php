<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttCategoryRequest;
use App\Http\Requests\StoreAttCategoryRequest;
use App\Http\Requests\UpdateAttCategoryRequest;
use App\Models\AttCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttCategoryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttCategory::with(['team'])->select(sprintf('%s.*', (new AttCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_category_show';
                $editGate = 'att_category_edit';
                $deleteGate = 'att_category_delete';
                $crudRoutePart = 'att-categories';

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

        return view('admin.attCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attCategories.create');
    }

    public function store(StoreAttCategoryRequest $request)
    {
        $attCategory = AttCategory::create($request->all());

        return redirect()->route('admin.att-categories.index');
    }

    public function edit(AttCategory $attCategory)
    {
        abort_if(Gate::denies('att_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategory->load('team');

        return view('admin.attCategories.edit', compact('attCategory'));
    }

    public function update(UpdateAttCategoryRequest $request, AttCategory $attCategory)
    {
        $attCategory->update($request->all());

        return redirect()->route('admin.att-categories.index');
    }

    public function show(AttCategory $attCategory)
    {
        abort_if(Gate::denies('att_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategory->load('team');

        return view('admin.attCategories.show', compact('attCategory'));
    }

    public function destroy(AttCategory $attCategory)
    {
        abort_if(Gate::denies('att_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttCategoryRequest $request)
    {
        AttCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
