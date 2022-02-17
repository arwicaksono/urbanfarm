<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPlotRequest;
use App\Http\Requests\StorePlotRequest;
use App\Http\Requests\UpdatePlotRequest;
use App\Models\AttTag;
use App\Models\Module;
use App\Models\Plot;
use App\Models\PlotCode;
use App\Models\PlotStage;
use App\Models\PlotVariety;
use App\Models\PurchaseBrand;
use App\Models\UnitQuantity;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlotController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('plot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Plot::with(['plot_prefix', 'activity', 'module', 'nutrient_brand', 'unit', 'variety', 'tags', 'team'])->select(sprintf('%s.*', (new Plot())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'plot_show';
                $editGate = 'plot_edit';
                $deleteGate = 'plot_delete';
                $crudRoutePart = 'plots';

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
            $table->addColumn('plot_prefix_prefix', function ($row) {
                return $row->plot_prefix ? $row->plot_prefix->prefix : '';
            });

            $table->addColumn('activity_name', function ($row) {
                return $row->activity ? $row->activity->name : '';
            });

            $table->addColumn('module_code', function ($row) {
                return $row->module ? $row->module->code : '';
            });

            $table->addColumn('nutrient_brand_name', function ($row) {
                return $row->nutrient_brand ? $row->nutrient_brand->name : '';
            });

            $table->editColumn('plot_qty', function ($row) {
                return $row->plot_qty ? $row->plot_qty : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
            });

            $table->addColumn('variety_name', function ($row) {
                return $row->variety ? $row->variety->name : '';
            });

            $table->editColumn('time_start', function ($row) {
                return $row->time_start ? $row->time_start : '';
            });

            $table->editColumn('time_end', function ($row) {
                return $row->time_end ? $row->time_end : '';
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Plot::IS_ACTIVE_SELECT[$row->is_active] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'plot_prefix', 'activity', 'module', 'nutrient_brand', 'unit', 'variety', 'tag', 'image']);

            return $table->make(true);
        }

        return view('admin.plots.index');
    }

    public function create()
    {
        abort_if(Gate::denies('plot_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plot_prefixes = PlotCode::pluck('prefix', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activities = PlotStage::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $modules = Module::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $nutrient_brands = PurchaseBrand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $varieties = PlotVariety::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        return view('admin.plots.create', compact('activities', 'modules', 'nutrient_brands', 'plot_prefixes', 'tags', 'units', 'varieties'));
    }

    public function store(StorePlotRequest $request)
    {
        $plot = Plot::create($request->all());
        $plot->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $plot->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $plot->id]);
        }

        return redirect()->route('admin.plots.index');
    }

    public function edit(Plot $plot)
    {
        abort_if(Gate::denies('plot_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plot_prefixes = PlotCode::pluck('prefix', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activities = PlotStage::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $modules = Module::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $nutrient_brands = PurchaseBrand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $varieties = PlotVariety::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $plot->load('plot_prefix', 'activity', 'module', 'nutrient_brand', 'unit', 'variety', 'tags', 'team');

        return view('admin.plots.edit', compact('activities', 'modules', 'nutrient_brands', 'plot', 'plot_prefixes', 'tags', 'units', 'varieties'));
    }

    public function update(UpdatePlotRequest $request, Plot $plot)
    {
        $plot->update($request->all());
        $plot->tags()->sync($request->input('tags', []));
        if (count($plot->image) > 0) {
            foreach ($plot->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $plot->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $plot->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.plots.index');
    }

    public function show(Plot $plot)
    {
        abort_if(Gate::denies('plot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plot->load('plot_prefix', 'activity', 'module', 'nutrient_brand', 'unit', 'variety', 'tags', 'team');

        return view('admin.plots.show', compact('plot'));
    }

    public function destroy(Plot $plot)
    {
        abort_if(Gate::denies('plot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plot->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlotRequest $request)
    {
        Plot::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('plot_create') && Gate::denies('plot_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Plot();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
