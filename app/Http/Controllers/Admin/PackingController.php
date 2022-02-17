<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPackingRequest;
use App\Http\Requests\StorePackingRequest;
use App\Http\Requests\UpdatePackingRequest;
use App\Models\AttPriority;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\Harvest;
use App\Models\Packing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PackingController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('packing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Packing::with(['harvest_codes', 'status', 'tags', 'priority', 'person_in_charge', 'team'])->select(sprintf('%s.*', (new Packing())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'packing_show';
                $editGate = 'packing_edit';
                $deleteGate = 'packing_delete';
                $crudRoutePart = 'packings';

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
            $table->editColumn('harvest_code', function ($row) {
                $labels = [];
                foreach ($row->harvest_codes as $harvest_code) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $harvest_code->code);
                }

                return implode(' ', $labels);
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
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Packing::IS_ACTIVE_SELECT[$row->is_active] : '';
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? Packing::IS_PROBLEM_SELECT[$row->is_problem] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'harvest_code', 'status', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.packings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('packing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $harvest_codes = Harvest::pluck('code', 'id');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.packings.create', compact('harvest_codes', 'person_in_charges', 'priorities', 'statuses', 'tags'));
    }

    public function store(StorePackingRequest $request)
    {
        $packing = Packing::create($request->all());
        $packing->harvest_codes()->sync($request->input('harvest_codes', []));
        $packing->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $packing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $packing->id]);
        }

        return redirect()->route('admin.packings.index');
    }

    public function edit(Packing $packing)
    {
        abort_if(Gate::denies('packing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $harvest_codes = Harvest::pluck('code', 'id');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $packing->load('harvest_codes', 'status', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.packings.edit', compact('harvest_codes', 'packing', 'person_in_charges', 'priorities', 'statuses', 'tags'));
    }

    public function update(UpdatePackingRequest $request, Packing $packing)
    {
        $packing->update($request->all());
        $packing->harvest_codes()->sync($request->input('harvest_codes', []));
        $packing->tags()->sync($request->input('tags', []));
        if (count($packing->image) > 0) {
            foreach ($packing->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $packing->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $packing->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.packings.index');
    }

    public function show(Packing $packing)
    {
        abort_if(Gate::denies('packing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing->load('harvest_codes', 'status', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.packings.show', compact('packing'));
    }

    public function destroy(Packing $packing)
    {
        abort_if(Gate::denies('packing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing->delete();

        return back();
    }

    public function massDestroy(MassDestroyPackingRequest $request)
    {
        Packing::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('packing_create') && Gate::denies('packing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Packing();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
