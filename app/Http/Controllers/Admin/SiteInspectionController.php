<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySiteInspectionRequest;
use App\Http\Requests\StoreSiteInspectionRequest;
use App\Http\Requests\UpdateSiteInspectionRequest;
use App\Models\AttPriority;
use App\Models\AttTag;
use App\Models\Site;
use App\Models\SiteInspection;
use App\Models\SiteWeather;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SiteInspectionController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('site_inspection_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SiteInspection::with(['site', 'weather', 'tags', 'priority', 'person_in_charge', 'team'])->select(sprintf('%s.*', (new SiteInspection())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'site_inspection_show';
                $editGate = 'site_inspection_edit';
                $deleteGate = 'site_inspection_delete';
                $crudRoutePart = 'site-inspections';

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
            $table->addColumn('site_code', function ($row) {
                return $row->site ? $row->site->code : '';
            });

            $table->editColumn('temperature', function ($row) {
                return $row->temperature ? $row->temperature : '';
            });
            $table->editColumn('humidity', function ($row) {
                return $row->humidity ? $row->humidity : '';
            });
            $table->addColumn('weather_name', function ($row) {
                return $row->weather ? $row->weather->name : '';
            });

            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? SiteInspection::IS_PROBLEM_SELECT[$row->is_problem] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'site', 'weather', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.siteInspections.index');
    }

    public function create()
    {
        abort_if(Gate::denies('site_inspection_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sites = Site::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $weather = SiteWeather::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.siteInspections.create', compact('person_in_charges', 'priorities', 'sites', 'tags', 'weather'));
    }

    public function store(StoreSiteInspectionRequest $request)
    {
        $siteInspection = SiteInspection::create($request->all());
        $siteInspection->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $siteInspection->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $siteInspection->id]);
        }

        return redirect()->route('admin.site-inspections.index');
    }

    public function edit(SiteInspection $siteInspection)
    {
        abort_if(Gate::denies('site_inspection_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sites = Site::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $weather = SiteWeather::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $siteInspection->load('site', 'weather', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.siteInspections.edit', compact('person_in_charges', 'priorities', 'siteInspection', 'sites', 'tags', 'weather'));
    }

    public function update(UpdateSiteInspectionRequest $request, SiteInspection $siteInspection)
    {
        $siteInspection->update($request->all());
        $siteInspection->tags()->sync($request->input('tags', []));
        if (count($siteInspection->image) > 0) {
            foreach ($siteInspection->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $siteInspection->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $siteInspection->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.site-inspections.index');
    }

    public function show(SiteInspection $siteInspection)
    {
        abort_if(Gate::denies('site_inspection_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteInspection->load('site', 'weather', 'tags', 'priority', 'person_in_charge', 'team');

        return view('admin.siteInspections.show', compact('siteInspection'));
    }

    public function destroy(SiteInspection $siteInspection)
    {
        abort_if(Gate::denies('site_inspection_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $siteInspection->delete();

        return back();
    }

    public function massDestroy(MassDestroySiteInspectionRequest $request)
    {
        SiteInspection::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('site_inspection_create') && Gate::denies('site_inspection_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SiteInspection();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
