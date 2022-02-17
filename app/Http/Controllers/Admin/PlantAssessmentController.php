<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPlantAssessmentRequest;
use App\Http\Requests\StorePlantAssessmentRequest;
use App\Http\Requests\UpdatePlantAssessmentRequest;
use App\Models\AttPriority;
use App\Models\AttTag;
use App\Models\PlantAssessment;
use App\Models\Plot;
use App\Models\UnitAge;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlantAssessmentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('plant_assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PlantAssessment::with(['plot', 'unit', 'tags', 'priority', 'person_in_charge', 'team'])->select(sprintf('%s.*', (new PlantAssessment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'plant_assessment_show';
                $editGate = 'plant_assessment_edit';
                $deleteGate = 'plant_assessment_delete';
                $crudRoutePart = 'plant-assessments';

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
            $table->addColumn('plot_code', function ($row) {
                return $row->plot ? $row->plot->code : '';
            });

            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
            });

            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? PlantAssessment::IS_PROBLEM_SELECT[$row->is_problem] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'plot', 'unit', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.plantAssessments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('plant_assessment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plots = Plot::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitAge::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.plantAssessments.create', compact('person_in_charges', 'plots', 'priorities', 'tags', 'units'));
    }

    public function store(StorePlantAssessmentRequest $request)
    {
        $plantAssessment = PlantAssessment::create($request->all());
        $plantAssessment->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $plantAssessment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $plantAssessment->id]);
        }

        return redirect()->route('admin.plant-assessments.index');
    }

    public function edit(PlantAssessment $plantAssessment)
    {
        abort_if(Gate::denies('plant_assessment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plots = Plot::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitAge::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plantAssessment->load('plot', 'unit', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.plantAssessments.edit', compact('person_in_charges', 'plantAssessment', 'plots', 'priorities', 'tags', 'units'));
    }

    public function update(UpdatePlantAssessmentRequest $request, PlantAssessment $plantAssessment)
    {
        $plantAssessment->update($request->all());
        $plantAssessment->tags()->sync($request->input('tags', []));
        if (count($plantAssessment->image) > 0) {
            foreach ($plantAssessment->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $plantAssessment->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $plantAssessment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.plant-assessments.index');
    }

    public function show(PlantAssessment $plantAssessment)
    {
        abort_if(Gate::denies('plant_assessment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plantAssessment->load('plot', 'unit', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.plantAssessments.show', compact('plantAssessment'));
    }

    public function destroy(PlantAssessment $plantAssessment)
    {
        abort_if(Gate::denies('plant_assessment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plantAssessment->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlantAssessmentRequest $request)
    {
        PlantAssessment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('plant_assessment_create') && Gate::denies('plant_assessment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PlantAssessment();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
