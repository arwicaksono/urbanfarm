<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarePackingRequest;
use App\Http\Requests\StoreCarePackingRequest;
use App\Http\Requests\UpdateCarePackingRequest;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CarePacking;
use App\Models\Packing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CarePackingController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_packing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CarePacking::with(['problem_packing', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CarePacking())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_packing_show';
                $editGate = 'care_packing_edit';
                $deleteGate = 'care_packing_delete';
                $crudRoutePart = 'care-packings';

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
            $table->addColumn('problem_packing_code', function ($row) {
                return $row->problem_packing ? $row->problem_packing->code : '';
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
                return $row->is_done ? CarePacking::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'problem_packing', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.carePackings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_packing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_packings = Packing::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.carePackings.create', compact('person_in_charges', 'problem_packings', 'statuses', 'tags'));
    }

    public function store(StoreCarePackingRequest $request)
    {
        $carePacking = CarePacking::create($request->all());
        $carePacking->tags()->sync($request->input('tags', []));
        $carePacking->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $carePacking->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carePacking->id]);
        }

        return redirect()->route('admin.care-packings.index');
    }

    public function edit(CarePacking $carePacking)
    {
        abort_if(Gate::denies('care_packing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_packings = Packing::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $carePacking->load('problem_packing', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.carePackings.edit', compact('carePacking', 'person_in_charges', 'problem_packings', 'statuses', 'tags'));
    }

    public function update(UpdateCarePackingRequest $request, CarePacking $carePacking)
    {
        $carePacking->update($request->all());
        $carePacking->tags()->sync($request->input('tags', []));
        $carePacking->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($carePacking->image) > 0) {
            foreach ($carePacking->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carePacking->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $carePacking->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.care-packings.index');
    }

    public function show(CarePacking $carePacking)
    {
        abort_if(Gate::denies('care_packing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePacking->load('problem_packing', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.carePackings.show', compact('carePacking'));
    }

    public function destroy(CarePacking $carePacking)
    {
        abort_if(Gate::denies('care_packing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePacking->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarePackingRequest $request)
    {
        CarePacking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_packing_create') && Gate::denies('care_packing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CarePacking();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
