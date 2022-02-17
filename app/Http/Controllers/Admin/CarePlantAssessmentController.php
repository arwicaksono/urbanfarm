<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarePlantAssessmentRequest;
use App\Http\Requests\StoreCarePlantAssessmentRequest;
use App\Http\Requests\UpdateCarePlantAssessmentRequest;
use App\Models\AttEfficacy;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CarePlantAssessment;
use App\Models\PlantAssessment;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CarePlantAssessmentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_plant_assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CarePlantAssessment::with(['problem_pa', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CarePlantAssessment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_plant_assessment_show';
                $editGate = 'care_plant_assessment_edit';
                $deleteGate = 'care_plant_assessment_delete';
                $crudRoutePart = 'care-plant-assessments';

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
            $table->addColumn('problem_pa_code', function ($row) {
                return $row->problem_pa ? $row->problem_pa->code : '';
            });

            $table->editColumn('action', function ($row) {
                return $row->action ? $row->action : '';
            });

            $table->editColumn('time_start', function ($row) {
                return $row->time_start ? $row->time_start : '';
            });
            $table->editColumn('time_end', function ($row) {
                return $row->time_end ? $row->time_end : '';
            });
            $table->addColumn('efficacy_name', function ($row) {
                return $row->efficacy ? $row->efficacy->name : '';
            });

            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_done', function ($row) {
                return $row->is_done ? CarePlantAssessment::IS_DONE_SELECT[$row->is_done] : '';
            });
            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });
            $table->editColumn('person_in_charge', function ($row) {
                $labels = [];
                foreach ($row->person_in_charges as $person_in_charge) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $person_in_charge->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'problem_pa', 'efficacy', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.carePlantAssessments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_plant_assessment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_pas = PlantAssessment::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $efficacies = AttEfficacy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.carePlantAssessments.create', compact('efficacies', 'person_in_charges', 'problem_pas', 'statuses', 'tags'));
    }

    public function store(StoreCarePlantAssessmentRequest $request)
    {
        $carePlantAssessment = CarePlantAssessment::create($request->all());
        $carePlantAssessment->tags()->sync($request->input('tags', []));
        $carePlantAssessment->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $carePlantAssessment->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carePlantAssessment->id]);
        }

        return redirect()->route('admin.care-plant-assessments.index');
    }

    public function edit(CarePlantAssessment $carePlantAssessment)
    {
        abort_if(Gate::denies('care_plant_assessment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_pas = PlantAssessment::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $efficacies = AttEfficacy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $carePlantAssessment->load('problem_pa', 'efficacy', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.carePlantAssessments.edit', compact('carePlantAssessment', 'efficacies', 'person_in_charges', 'problem_pas', 'statuses', 'tags'));
    }

    public function update(UpdateCarePlantAssessmentRequest $request, CarePlantAssessment $carePlantAssessment)
    {
        $carePlantAssessment->update($request->all());
        $carePlantAssessment->tags()->sync($request->input('tags', []));
        $carePlantAssessment->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$carePlantAssessment->image || $request->input('image') !== $carePlantAssessment->image->file_name) {
                if ($carePlantAssessment->image) {
                    $carePlantAssessment->image->delete();
                }
                $carePlantAssessment->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($carePlantAssessment->image) {
            $carePlantAssessment->image->delete();
        }

        return redirect()->route('admin.care-plant-assessments.index');
    }

    public function show(CarePlantAssessment $carePlantAssessment)
    {
        abort_if(Gate::denies('care_plant_assessment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePlantAssessment->load('problem_pa', 'efficacy', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.carePlantAssessments.show', compact('carePlantAssessment'));
    }

    public function destroy(CarePlantAssessment $carePlantAssessment)
    {
        abort_if(Gate::denies('care_plant_assessment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePlantAssessment->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarePlantAssessmentRequest $request)
    {
        CarePlantAssessment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_plant_assessment_create') && Gate::denies('care_plant_assessment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CarePlantAssessment();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
