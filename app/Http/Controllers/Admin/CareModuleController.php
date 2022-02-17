<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCareModuleRequest;
use App\Http\Requests\StoreCareModuleRequest;
use App\Http\Requests\UpdateCareModuleRequest;
use App\Models\AttEfficacy;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CareModule;
use App\Models\ModuleObservation;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CareModuleController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CareModule::with(['problem_mo', 'efficacy', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CareModule())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_module_show';
                $editGate = 'care_module_edit';
                $deleteGate = 'care_module_delete';
                $crudRoutePart = 'care-modules';

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
            $table->addColumn('problem_mo_code', function ($row) {
                return $row->problem_mo ? $row->problem_mo->code : '';
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
                return $row->is_done ? CareModule::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'problem_mo', 'efficacy', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.careModules.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_mos = ModuleObservation::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $efficacies = AttEfficacy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.careModules.create', compact('efficacies', 'person_in_charges', 'problem_mos', 'statuses', 'tags'));
    }

    public function store(StoreCareModuleRequest $request)
    {
        $careModule = CareModule::create($request->all());
        $careModule->tags()->sync($request->input('tags', []));
        $careModule->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            $careModule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $careModule->id]);
        }

        return redirect()->route('admin.care-modules.index');
    }

    public function edit(CareModule $careModule)
    {
        abort_if(Gate::denies('care_module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_mos = ModuleObservation::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $efficacies = AttEfficacy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $careModule->load('problem_mo', 'efficacy', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careModules.edit', compact('careModule', 'efficacies', 'person_in_charges', 'problem_mos', 'statuses', 'tags'));
    }

    public function update(UpdateCareModuleRequest $request, CareModule $careModule)
    {
        $careModule->update($request->all());
        $careModule->tags()->sync($request->input('tags', []));
        $careModule->person_in_charges()->sync($request->input('person_in_charges', []));
        if ($request->input('image', false)) {
            if (!$careModule->image || $request->input('image') !== $careModule->image->file_name) {
                if ($careModule->image) {
                    $careModule->image->delete();
                }
                $careModule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($careModule->image) {
            $careModule->image->delete();
        }

        return redirect()->route('admin.care-modules.index');
    }

    public function show(CareModule $careModule)
    {
        abort_if(Gate::denies('care_module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careModule->load('problem_mo', 'efficacy', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careModules.show', compact('careModule'));
    }

    public function destroy(CareModule $careModule)
    {
        abort_if(Gate::denies('care_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careModule->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareModuleRequest $request)
    {
        CareModule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_module_create') && Gate::denies('care_module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CareModule();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
