<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyModuleRequest;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Models\Module;
use App\Models\ModuleActivity;
use App\Models\ModuleComponent;
use App\Models\ModuleSystem;
use App\Models\Site;
use App\Models\UnitCapacity;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ModuleController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Module::with(['site_code', 'system', 'lighting', 'reservoir', 'pump', 'mounting', 'unit', 'acitivities', 'team'])->select(sprintf('%s.*', (new Module())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'module_show';
                $editGate = 'module_edit';
                $deleteGate = 'module_delete';
                $crudRoutePart = 'modules';

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
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->editColumn('number', function ($row) {
                return $row->number ? $row->number : '';
            });
            $table->addColumn('site_code_code', function ($row) {
                return $row->site_code ? $row->site_code->code : '';
            });

            $table->addColumn('system_name', function ($row) {
                return $row->system ? $row->system->name : '';
            });

            $table->addColumn('lighting_code', function ($row) {
                return $row->lighting ? $row->lighting->code : '';
            });

            $table->addColumn('reservoir_code', function ($row) {
                return $row->reservoir ? $row->reservoir->code : '';
            });

            $table->addColumn('pump_code', function ($row) {
                return $row->pump ? $row->pump->code : '';
            });

            $table->addColumn('mounting_code', function ($row) {
                return $row->mounting ? $row->mounting->code : '';
            });

            $table->editColumn('capacity', function ($row) {
                return $row->capacity ? $row->capacity : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
            });

            $table->editColumn('acitivity', function ($row) {
                $labels = [];
                foreach ($row->acitivities as $acitivity) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $acitivity->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Module::IS_ACTIVE_SELECT[$row->is_active] : '';
            });
            $table->editColumn('image', function ($row) {
                if (!$row->image) {
                    return '';
                }
                $links = [];
                foreach ($row->image as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'site_code', 'system', 'lighting', 'reservoir', 'pump', 'mounting', 'unit', 'acitivity', 'image']);

            return $table->make(true);
        }

        return view('admin.modules.index');
    }

    public function create()
    {
        abort_if(Gate::denies('module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site_codes = Site::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $systems = ModuleSystem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lightings = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reservoirs = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pumps = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mountings = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitCapacity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $acitivities = ModuleActivity::pluck('name', 'id');

        return view('admin.modules.create', compact('acitivities', 'lightings', 'mountings', 'pumps', 'reservoirs', 'site_codes', 'systems', 'units'));
    }

    public function store(StoreModuleRequest $request)
    {
        $module = Module::create($request->all());
        $module->acitivities()->sync($request->input('acitivities', []));
        foreach ($request->input('image', []) as $file) {
            $module->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $module->id]);
        }

        return redirect()->route('admin.modules.index');
    }

    public function edit(Module $module)
    {
        abort_if(Gate::denies('module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site_codes = Site::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $systems = ModuleSystem::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lightings = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reservoirs = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pumps = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mountings = ModuleComponent::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitCapacity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $acitivities = ModuleActivity::pluck('name', 'id');

        $module->load('site_code', 'system', 'lighting', 'reservoir', 'pump', 'mounting', 'unit', 'acitivities', 'team');

        return view('admin.modules.edit', compact('acitivities', 'lightings', 'module', 'mountings', 'pumps', 'reservoirs', 'site_codes', 'systems', 'units'));
    }

    public function update(UpdateModuleRequest $request, Module $module)
    {
        $module->update($request->all());
        $module->acitivities()->sync($request->input('acitivities', []));
        if (count($module->image) > 0) {
            foreach ($module->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $module->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $module->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.modules.index');
    }

    public function show(Module $module)
    {
        abort_if(Gate::denies('module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $module->load('site_code', 'system', 'lighting', 'reservoir', 'pump', 'mounting', 'unit', 'acitivities', 'team');

        return view('admin.modules.show', compact('module'));
    }

    public function destroy(Module $module)
    {
        abort_if(Gate::denies('module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $module->delete();

        return back();
    }

    public function massDestroy(MassDestroyModuleRequest $request)
    {
        Module::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('module_create') && Gate::denies('module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Module();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
