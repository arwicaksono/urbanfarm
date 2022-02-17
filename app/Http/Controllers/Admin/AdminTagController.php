<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdminTagRequest;
use App\Http\Requests\StoreAdminTagRequest;
use App\Http\Requests\UpdateAdminTagRequest;
use App\Models\AdminTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminTagController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AdminTag::query()->select(sprintf('%s.*', (new AdminTag())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'admin_tag_show';
                $editGate = 'admin_tag_edit';
                $deleteGate = 'admin_tag_delete';
                $crudRoutePart = 'admin-tags';

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

        return view('admin.adminTags.index');
    }

    public function create()
    {
        abort_if(Gate::denies('admin_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminTags.create');
    }

    public function store(StoreAdminTagRequest $request)
    {
        $adminTag = AdminTag::create($request->all());

        return redirect()->route('admin.admin-tags.index');
    }

    public function edit(AdminTag $adminTag)
    {
        abort_if(Gate::denies('admin_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminTags.edit', compact('adminTag'));
    }

    public function update(UpdateAdminTagRequest $request, AdminTag $adminTag)
    {
        $adminTag->update($request->all());

        return redirect()->route('admin.admin-tags.index');
    }

    public function show(AdminTag $adminTag)
    {
        abort_if(Gate::denies('admin_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminTags.show', compact('adminTag'));
    }

    public function destroy(AdminTag $adminTag)
    {
        abort_if(Gate::denies('admin_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminTagRequest $request)
    {
        AdminTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
