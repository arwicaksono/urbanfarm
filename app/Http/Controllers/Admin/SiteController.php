<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySiteRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Site;
use App\Models\SiteSetting;
use App\Models\SiteWaterSource;
use App\Models\UnitArea;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SiteController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('site_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Site::with(['unit', 'settings', 'water_sources', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new Site())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'site_show';
                $editGate = 'site_edit';
                $deleteGate = 'site_delete';
                $crudRoutePart = 'sites';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('location', function ($row) {
                return $row->location ? $row->location : '';
            });
            $table->editColumn('elevation', function ($row) {
                return $row->elevation ? $row->elevation : '';
            });
            $table->editColumn('acreage', function ($row) {
                return $row->acreage ? $row->acreage : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
            });

            $table->editColumn('setting', function ($row) {
                $labels = [];
                foreach ($row->settings as $setting) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $setting->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('water_source', function ($row) {
                $labels = [];
                foreach ($row->water_sources as $water_source) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $water_source->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? Site::IS_ACTIVE_SELECT[$row->is_active] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'unit', 'setting', 'water_source', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.sites.index');
    }

    public function create()
    {
        abort_if(Gate::denies('site_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $settings = SiteSetting::pluck('name', 'id');

        $water_sources = SiteWaterSource::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.sites.create', compact('person_in_charges', 'settings', 'units', 'water_sources'));
    }

    public function store(StoreSiteRequest $request)
    {
        $site = Site::create($request->all());
        $site->settings()->sync($request->input('settings', []));
        $site->water_sources()->sync($request->input('water_sources', []));
        $site->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $site->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $site->id]);
        }

        return redirect()->route('admin.sites.index');
    }

    public function edit(Site $site)
    {
        abort_if(Gate::denies('site_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitArea::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $settings = SiteSetting::pluck('name', 'id');

        $water_sources = SiteWaterSource::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $site->load('unit', 'settings', 'water_sources', 'person_in_charges', 'team');

        return view('admin.sites.edit', compact('person_in_charges', 'settings', 'site', 'units', 'water_sources'));
    }

    public function update(UpdateSiteRequest $request, Site $site)
    {
        $site->update($request->all());
        $site->settings()->sync($request->input('settings', []));
        $site->water_sources()->sync($request->input('water_sources', []));
        $site->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($site->image) > 0) {
            foreach ($site->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $site->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $site->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.sites.index');
    }

    public function show(Site $site)
    {
        abort_if(Gate::denies('site_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->load('unit', 'settings', 'water_sources', 'person_in_charges', 'team');

        return view('admin.sites.show', compact('site'));
    }

    public function destroy(Site $site)
    {
        abort_if(Gate::denies('site_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->delete();

        return back();
    }

    public function massDestroy(MassDestroySiteRequest $request)
    {
        Site::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('site_create') && Gate::denies('site_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Site();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
