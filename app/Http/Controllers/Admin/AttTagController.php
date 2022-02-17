<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAttTagRequest;
use App\Http\Requests\StoreAttTagRequest;
use App\Http\Requests\UpdateAttTagRequest;
use App\Models\AttTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AttTagController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('att_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AttTag::with(['team'])->select(sprintf('%s.*', (new AttTag())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'att_tag_show';
                $editGate = 'att_tag_edit';
                $deleteGate = 'att_tag_delete';
                $crudRoutePart = 'att-tags';

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

        return view('admin.attTags.index');
    }

    public function create()
    {
        abort_if(Gate::denies('att_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.attTags.create');
    }

    public function store(StoreAttTagRequest $request)
    {
        $attTag = AttTag::create($request->all());

        return redirect()->route('admin.att-tags.index');
    }

    public function edit(AttTag $attTag)
    {
        abort_if(Gate::denies('att_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attTag->load('team');

        return view('admin.attTags.edit', compact('attTag'));
    }

    public function update(UpdateAttTagRequest $request, AttTag $attTag)
    {
        $attTag->update($request->all());

        return redirect()->route('admin.att-tags.index');
    }

    public function show(AttTag $attTag)
    {
        abort_if(Gate::denies('att_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attTag->load('team');

        return view('admin.attTags.show', compact('attTag'));
    }

    public function destroy(AttTag $attTag)
    {
        abort_if(Gate::denies('att_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttTagRequest $request)
    {
        AttTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
