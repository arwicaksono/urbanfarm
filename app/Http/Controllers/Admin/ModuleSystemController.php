<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyModuleSystemRequest;
use App\Http\Requests\StoreModuleSystemRequest;
use App\Http\Requests\UpdateModuleSystemRequest;
use App\Models\ModuleSystem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ModuleSystemController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('module_system_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ModuleSystem::with(['team'])->select(sprintf('%s.*', (new ModuleSystem())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'module_system_show';
                $editGate = 'module_system_edit';
                $deleteGate = 'module_system_delete';
                $crudRoutePart = 'module-systems';

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

        return view('admin.moduleSystems.index');
    }

    public function create()
    {
        abort_if(Gate::denies('module_system_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.moduleSystems.create');
    }

    public function store(StoreModuleSystemRequest $request)
    {
        $moduleSystem = ModuleSystem::create($request->all());

        return redirect()->route('admin.module-systems.index');
    }

    public function edit(ModuleSystem $moduleSystem)
    {
        abort_if(Gate::denies('module_system_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleSystem->load('team');

        return view('admin.moduleSystems.edit', compact('moduleSystem'));
    }

    public function update(UpdateModuleSystemRequest $request, ModuleSystem $moduleSystem)
    {
        $moduleSystem->update($request->all());

        return redirect()->route('admin.module-systems.index');
    }

    public function show(ModuleSystem $moduleSystem)
    {
        abort_if(Gate::denies('module_system_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleSystem->load('team');

        return view('admin.moduleSystems.show', compact('moduleSystem'));
    }

    public function destroy(ModuleSystem $moduleSystem)
    {
        abort_if(Gate::denies('module_system_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleSystem->delete();

        return back();
    }

    public function massDestroy(MassDestroyModuleSystemRequest $request)
    {
        ModuleSystem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
