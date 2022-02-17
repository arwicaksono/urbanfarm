<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyNutrientControlRequest;
use App\Http\Requests\StoreNutrientControlRequest;
use App\Http\Requests\UpdateNutrientControlRequest;
use App\Models\AttPriority;
use App\Models\AttTag;
use App\Models\Module;
use App\Models\NutrientControl;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class NutrientControlController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('nutrient_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = NutrientControl::with(['module', 'tags', 'priority', 'person_in_charge', 'team'])->select(sprintf('%s.*', (new NutrientControl())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'nutrient_control_show';
                $editGate = 'nutrient_control_edit';
                $deleteGate = 'nutrient_control_delete';
                $crudRoutePart = 'nutrient-controls';

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

            $table->editColumn('ppm', function ($row) {
                return $row->ppm ? $row->ppm : '';
            });
            $table->editColumn('ec', function ($row) {
                return $row->ec ? $row->ec : '';
            });
            $table->editColumn('ph', function ($row) {
                return $row->ph ? $row->ph : '';
            });
            $table->editColumn('temperature', function ($row) {
                return $row->temperature ? $row->temperature : '';
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? NutrientControl::IS_PROBLEM_SELECT[$row->is_problem] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'module', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.nutrientControls.index');
    }

    public function create()
    {
        abort_if(Gate::denies('nutrient_control_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $modules = Module::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.nutrientControls.create', compact('modules', 'person_in_charges', 'priorities', 'tags'));
    }

    public function store(StoreNutrientControlRequest $request)
    {
        $nutrientControl = NutrientControl::create($request->all());
        $nutrientControl->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $nutrientControl->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $nutrientControl->id]);
        }

        return redirect()->route('admin.nutrient-controls.index');
    }

    public function edit(NutrientControl $nutrientControl)
    {
        abort_if(Gate::denies('nutrient_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $modules = Module::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $nutrientControl->load('module', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.nutrientControls.edit', compact('modules', 'nutrientControl', 'person_in_charges', 'priorities', 'tags'));
    }

    public function update(UpdateNutrientControlRequest $request, NutrientControl $nutrientControl)
    {
        $nutrientControl->update($request->all());
        $nutrientControl->tags()->sync($request->input('tags', []));
        if (count($nutrientControl->image) > 0) {
            foreach ($nutrientControl->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $nutrientControl->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $nutrientControl->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.nutrient-controls.index');
    }

    public function show(NutrientControl $nutrientControl)
    {
        abort_if(Gate::denies('nutrient_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $nutrientControl->load('module', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.nutrientControls.show', compact('nutrientControl'));
    }

    public function destroy(NutrientControl $nutrientControl)
    {
        abort_if(Gate::denies('nutrient_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $nutrientControl->delete();

        return back();
    }

    public function massDestroy(MassDestroyNutrientControlRequest $request)
    {
        NutrientControl::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('nutrient_control_create') && Gate::denies('nutrient_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new NutrientControl();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
