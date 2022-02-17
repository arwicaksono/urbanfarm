<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCareHarvestRequest;
use App\Http\Requests\StoreCareHarvestRequest;
use App\Http\Requests\UpdateCareHarvestRequest;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CareHarvest;
use App\Models\Harvest;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CareHarvestController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_harvest_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CareHarvest::with(['problem_harvest', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CareHarvest())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_harvest_show';
                $editGate = 'care_harvest_edit';
                $deleteGate = 'care_harvest_delete';
                $crudRoutePart = 'care-harvests';

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
            $table->addColumn('problem_harvest_code', function ($row) {
                return $row->problem_harvest ? $row->problem_harvest->code : '';
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
                return $row->is_done ? CareHarvest::IS_DONE_SELECT[$row->is_done] : '';
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
            $table->editColumn('person_in_charge', function ($row) {
                $labels = [];
                foreach ($row->person_in_charges as $person_in_charge) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $person_in_charge->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'problem_harvest', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.careHarvests.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_harvest_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_harvests = Harvest::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.careHarvests.create', compact('person_in_charges', 'problem_harvests', 'statuses', 'tags'));
    }

    public function store(StoreCareHarvestRequest $request)
    {
        $careHarvest = CareHarvest::create($request->all());
        $careHarvest->tags()->sync($request->input('tags', []));
        $careHarvest->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $careHarvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $careHarvest->id]);
        }

        return redirect()->route('admin.care-harvests.index');
    }

    public function edit(CareHarvest $careHarvest)
    {
        abort_if(Gate::denies('care_harvest_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_harvests = Harvest::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $careHarvest->load('problem_harvest', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careHarvests.edit', compact('careHarvest', 'person_in_charges', 'problem_harvests', 'statuses', 'tags'));
    }

    public function update(UpdateCareHarvestRequest $request, CareHarvest $careHarvest)
    {
        $careHarvest->update($request->all());
        $careHarvest->tags()->sync($request->input('tags', []));
        $careHarvest->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($careHarvest->image) > 0) {
            foreach ($careHarvest->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $careHarvest->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $careHarvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.care-harvests.index');
    }

    public function show(CareHarvest $careHarvest)
    {
        abort_if(Gate::denies('care_harvest_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careHarvest->load('problem_harvest', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careHarvests.show', compact('careHarvest'));
    }

    public function destroy(CareHarvest $careHarvest)
    {
        abort_if(Gate::denies('care_harvest_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careHarvest->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareHarvestRequest $request)
    {
        CareHarvest::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_harvest_create') && Gate::denies('care_harvest_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CareHarvest();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
