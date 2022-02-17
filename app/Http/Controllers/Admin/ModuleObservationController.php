<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyModuleObservationRequest;
use App\Http\Requests\StoreModuleObservationRequest;
use App\Http\Requests\UpdateModuleObservationRequest;
use App\Models\AttPriority;
use App\Models\AttTag;
use App\Models\Module;
use App\Models\ModuleComponent;
use App\Models\ModuleObservation;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ModuleObservationController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('module_observation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ModuleObservation::with(['module', 'components', 'tags', 'priority', 'person_in_charge', 'team'])->select(sprintf('%s.*', (new ModuleObservation())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'module_observation_show';
                $editGate = 'module_observation_edit';
                $deleteGate = 'module_observation_delete';
                $crudRoutePart = 'module-observations';

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

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : '';
            });
            $table->addColumn('module_code', function ($row) {
                return $row->module ? $row->module->code : '';
            });

            $table->editColumn('component', function ($row) {
                $labels = [];
                foreach ($row->components as $component) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $component->code);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? ModuleObservation::IS_PROBLEM_SELECT[$row->is_problem] : '';
            });
            $table->addColumn('priority_name', function ($row) {
                return $row->priority ? $row->priority->name : '';
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
            $table->addColumn('person_in_charge_name', function ($row) {
                return $row->person_in_charge ? $row->person_in_charge->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'module', 'component', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.moduleObservations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('module_observation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $modules = Module::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $components = ModuleComponent::pluck('code', 'id');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.moduleObservations.create', compact('components', 'modules', 'person_in_charges', 'priorities', 'tags'));
    }

    public function store(StoreModuleObservationRequest $request)
    {
        $moduleObservation = ModuleObservation::create($request->all());
        $moduleObservation->components()->sync($request->input('components', []));
        $moduleObservation->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $moduleObservation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $moduleObservation->id]);
        }

        return redirect()->route('admin.module-observations.index');
    }

    public function edit(ModuleObservation $moduleObservation)
    {
        abort_if(Gate::denies('module_observation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $modules = Module::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $components = ModuleComponent::pluck('code', 'id');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moduleObservation->load('module', 'components', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.moduleObservations.edit', compact('components', 'moduleObservation', 'modules', 'person_in_charges', 'priorities', 'tags'));
    }

    public function update(UpdateModuleObservationRequest $request, ModuleObservation $moduleObservation)
    {
        $moduleObservation->update($request->all());
        $moduleObservation->components()->sync($request->input('components', []));
        $moduleObservation->tags()->sync($request->input('tags', []));
        if (count($moduleObservation->image) > 0) {
            foreach ($moduleObservation->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $moduleObservation->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $moduleObservation->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.module-observations.index');
    }

    public function show(ModuleObservation $moduleObservation)
    {
        abort_if(Gate::denies('module_observation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleObservation->load('module', 'components', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.moduleObservations.show', compact('moduleObservation'));
    }

    public function destroy(ModuleObservation $moduleObservation)
    {
        abort_if(Gate::denies('module_observation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleObservation->delete();

        return back();
    }

    public function massDestroy(MassDestroyModuleObservationRequest $request)
    {
        ModuleObservation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('module_observation_create') && Gate::denies('module_observation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ModuleObservation();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
