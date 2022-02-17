<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHarvestRequest;
use App\Http\Requests\StoreHarvestRequest;
use App\Http\Requests\UpdateHarvestRequest;
use App\Models\AttPriority;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\Harvest;
use App\Models\Plot;
use App\Models\ProductGrade;
use App\Models\UnitAge;
use App\Models\UnitQuantity;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HarvestController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('harvest_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Harvest::with(['plot', 'unit', 'grades', 'harvest_unit', 'status', 'tags', 'priority', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new Harvest())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'harvest_show';
                $editGate = 'harvest_edit';
                $deleteGate = 'harvest_delete';
                $crudRoutePart = 'harvests';

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

            $table->editColumn('round', function ($row) {
                return $row->round ? $row->round : '';
            });
            $table->editColumn('grade', function ($row) {
                $labels = [];
                foreach ($row->grades as $grade) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $grade->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('harvest_qty', function ($row) {
                return $row->harvest_qty ? $row->harvest_qty : '';
            });
            $table->addColumn('harvest_unit_name', function ($row) {
                return $row->harvest_unit ? $row->harvest_unit->name : '';
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
                return $row->is_active ? Harvest::IS_ACTIVE_SELECT[$row->is_active] : '';
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? Harvest::IS_PROBLEM_SELECT[$row->is_problem] : '';
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
            $table->editColumn('person_in_charge', function ($row) {
                $labels = [];
                foreach ($row->person_in_charges as $person_in_charge) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $person_in_charge->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'plot', 'unit', 'grade', 'harvest_unit', 'status', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.harvests.index');
    }

    public function create()
    {
        abort_if(Gate::denies('harvest_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plots = Plot::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitAge::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $grades = ProductGrade::pluck('name', 'id');

        $harvest_units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.harvests.create', compact('grades', 'harvest_units', 'person_in_charges', 'plots', 'priorities', 'statuses', 'tags', 'units'));
    }

    public function store(StoreHarvestRequest $request)
    {
        $harvest = Harvest::create($request->all());
        $harvest->grades()->sync($request->input('grades', []));
        $harvest->tags()->sync($request->input('tags', []));
        $harvest->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $harvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $harvest->id]);
        }

        return redirect()->route('admin.harvests.index');
    }

    public function edit(Harvest $harvest)
    {
        abort_if(Gate::denies('harvest_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plots = Plot::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitAge::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $grades = ProductGrade::pluck('name', 'id');

        $harvest_units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        $harvest->load('plot', 'unit', 'grades', 'harvest_unit', 'status', 'tags', 'priority', 'person_in_charges', 'team');

        return view('admin.harvests.edit', compact('grades', 'harvest', 'harvest_units', 'person_in_charges', 'plots', 'priorities', 'statuses', 'tags', 'units'));
    }

    public function update(UpdateHarvestRequest $request, Harvest $harvest)
    {
        $harvest->update($request->all());
        $harvest->grades()->sync($request->input('grades', []));
        $harvest->tags()->sync($request->input('tags', []));
        $harvest->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($harvest->image) > 0) {
            foreach ($harvest->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $harvest->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $harvest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.harvests.index');
    }

    public function show(Harvest $harvest)
    {
        abort_if(Gate::denies('harvest_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $harvest->load('plot', 'unit', 'grades', 'harvest_unit', 'status', 'tags', 'priority', 'person_in_charges', 'team');

        return view('admin.harvests.show', compact('harvest'));
    }

    public function destroy(Harvest $harvest)
    {
        abort_if(Gate::denies('harvest_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $harvest->delete();

        return back();
    }

    public function massDestroy(MassDestroyHarvestRequest $request)
    {
        Harvest::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('harvest_create') && Gate::denies('harvest_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Harvest();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
