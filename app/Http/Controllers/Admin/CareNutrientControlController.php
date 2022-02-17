<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCareNutrientControlRequest;
use App\Http\Requests\StoreCareNutrientControlRequest;
use App\Http\Requests\UpdateCareNutrientControlRequest;
use App\Models\AttEfficacy;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CareNutrientControl;
use App\Models\NutrientControl;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CareNutrientControlController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_nutrient_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CareNutrientControl::with(['problem_nc', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CareNutrientControl())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_nutrient_control_show';
                $editGate = 'care_nutrient_control_edit';
                $deleteGate = 'care_nutrient_control_delete';
                $crudRoutePart = 'care-nutrient-controls';

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
            $table->addColumn('problem_nc_code', function ($row) {
                return $row->problem_nc ? $row->problem_nc->code : '';
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
                return $row->is_done ? CareNutrientControl::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'problem_nc', 'efficacy', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.careNutrientControls.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_nutrient_control_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_ncs = NutrientControl::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $efficacies = AttEfficacy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.careNutrientControls.create', compact('efficacies', 'person_in_charges', 'problem_ncs', 'statuses', 'tags'));
    }

    public function store(StoreCareNutrientControlRequest $request)
    {
        $careNutrientControl = CareNutrientControl::create($request->all());
        $careNutrientControl->tags()->sync($request->input('tags', []));
        $careNutrientControl->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $careNutrientControl->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $careNutrientControl->id]);
        }

        return redirect()->route('admin.care-nutrient-controls.index');
    }

    public function edit(CareNutrientControl $careNutrientControl)
    {
        abort_if(Gate::denies('care_nutrient_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_ncs = NutrientControl::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $efficacies = AttEfficacy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $careNutrientControl->load('problem_nc', 'efficacy', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careNutrientControls.edit', compact('careNutrientControl', 'efficacies', 'person_in_charges', 'problem_ncs', 'statuses', 'tags'));
    }

    public function update(UpdateCareNutrientControlRequest $request, CareNutrientControl $careNutrientControl)
    {
        $careNutrientControl->update($request->all());
        $careNutrientControl->tags()->sync($request->input('tags', []));
        $careNutrientControl->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$careNutrientControl->image || $request->input('image') !== $careNutrientControl->image->file_name) {
                if ($careNutrientControl->image) {
                    $careNutrientControl->image->delete();
                }
                $careNutrientControl->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($careNutrientControl->image) {
            $careNutrientControl->image->delete();
        }

        return redirect()->route('admin.care-nutrient-controls.index');
    }

    public function show(CareNutrientControl $careNutrientControl)
    {
        abort_if(Gate::denies('care_nutrient_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careNutrientControl->load('problem_nc', 'efficacy', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careNutrientControls.show', compact('careNutrientControl'));
    }

    public function destroy(CareNutrientControl $careNutrientControl)
    {
        abort_if(Gate::denies('care_nutrient_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careNutrientControl->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareNutrientControlRequest $request)
    {
        CareNutrientControl::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_nutrient_control_create') && Gate::denies('care_nutrient_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CareNutrientControl();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
