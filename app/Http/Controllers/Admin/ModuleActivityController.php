<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyModuleActivityRequest;
use App\Http\Requests\StoreModuleActivityRequest;
use App\Http\Requests\UpdateModuleActivityRequest;
use App\Models\ModuleActivity;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ModuleActivityController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('module_activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ModuleActivity::with(['team'])->select(sprintf('%s.*', (new ModuleActivity())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'module_activity_show';
                $editGate = 'module_activity_edit';
                $deleteGate = 'module_activity_delete';
                $crudRoutePart = 'module-activities';

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

        return view('admin.moduleActivities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('module_activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.moduleActivities.create');
    }

    public function store(StoreModuleActivityRequest $request)
    {
        $moduleActivity = ModuleActivity::create($request->all());

        return redirect()->route('admin.module-activities.index');
    }

    public function edit(ModuleActivity $moduleActivity)
    {
        abort_if(Gate::denies('module_activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleActivity->load('team');

        return view('admin.moduleActivities.edit', compact('moduleActivity'));
    }

    public function update(UpdateModuleActivityRequest $request, ModuleActivity $moduleActivity)
    {
        $moduleActivity->update($request->all());

        return redirect()->route('admin.module-activities.index');
    }

    public function show(ModuleActivity $moduleActivity)
    {
        abort_if(Gate::denies('module_activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleActivity->load('team');

        return view('admin.moduleActivities.show', compact('moduleActivity'));
    }

    public function destroy(ModuleActivity $moduleActivity)
    {
        abort_if(Gate::denies('module_activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleActivity->delete();

        return back();
    }

    public function massDestroy(MassDestroyModuleActivityRequest $request)
    {
        ModuleActivity::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
