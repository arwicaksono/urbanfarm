<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCareDistributionRequest;
use App\Http\Requests\StoreCareDistributionRequest;
use App\Http\Requests\UpdateCareDistributionRequest;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CareDistribution;
use App\Models\Distribution;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CareDistributionController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CareDistribution::with(['problem_dist', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CareDistribution())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_distribution_show';
                $editGate = 'care_distribution_edit';
                $deleteGate = 'care_distribution_delete';
                $crudRoutePart = 'care-distributions';

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
            $table->addColumn('problem_dist_code', function ($row) {
                return $row->problem_dist ? $row->problem_dist->code : '';
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
                return $row->is_done ? CareDistribution::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'problem_dist', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.careDistributions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_dists = Distribution::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.careDistributions.create', compact('person_in_charges', 'problem_dists', 'statuses', 'tags'));
    }

    public function store(StoreCareDistributionRequest $request)
    {
        $careDistribution = CareDistribution::create($request->all());
        $careDistribution->tags()->sync($request->input('tags', []));
        $careDistribution->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $careDistribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $careDistribution->id]);
        }

        return redirect()->route('admin.care-distributions.index');
    }

    public function edit(CareDistribution $careDistribution)
    {
        abort_if(Gate::denies('care_distribution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_dists = Distribution::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $careDistribution->load('problem_dist', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careDistributions.edit', compact('careDistribution', 'person_in_charges', 'problem_dists', 'statuses', 'tags'));
    }

    public function update(UpdateCareDistributionRequest $request, CareDistribution $careDistribution)
    {
        $careDistribution->update($request->all());
        $careDistribution->tags()->sync($request->input('tags', []));
        $careDistribution->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($careDistribution->image) > 0) {
            foreach ($careDistribution->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $careDistribution->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $careDistribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.care-distributions.index');
    }

    public function show(CareDistribution $careDistribution)
    {
        abort_if(Gate::denies('care_distribution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careDistribution->load('problem_dist', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careDistributions.show', compact('careDistribution'));
    }

    public function destroy(CareDistribution $careDistribution)
    {
        abort_if(Gate::denies('care_distribution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careDistribution->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareDistributionRequest $request)
    {
        CareDistribution::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_distribution_create') && Gate::denies('care_distribution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CareDistribution();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
