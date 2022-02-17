<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBusinessSettingRequest;
use App\Http\Requests\StoreBusinessSettingRequest;
use App\Http\Requests\UpdateBusinessSettingRequest;
use App\Models\BusinessSetting;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BusinessSettingController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('business_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BusinessSetting::with(['team'])->select(sprintf('%s.*', (new BusinessSetting())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'business_setting_show';
                $editGate = 'business_setting_edit';
                $deleteGate = 'business_setting_delete';
                $crudRoutePart = 'business-settings';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('logo', function ($row) {
                if ($photo = $row->logo) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('banner', function ($row) {
                if ($photo = $row->banner) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('whatsapp', function ($row) {
                return $row->whatsapp ? $row->whatsapp : '';
            });
            $table->editColumn('telegram', function ($row) {
                return $row->telegram ? $row->telegram : '';
            });
            $table->editColumn('facebook', function ($row) {
                return $row->facebook ? $row->facebook : '';
            });
            $table->editColumn('twitter', function ($row) {
                return $row->twitter ? $row->twitter : '';
            });
            $table->editColumn('instagram', function ($row) {
                return $row->instagram ? $row->instagram : '';
            });
            $table->editColumn('linked_in', function ($row) {
                return $row->linked_in ? $row->linked_in : '';
            });
            $table->editColumn('youtube', function ($row) {
                return $row->youtube ? $row->youtube : '';
            });
            $table->editColumn('pinterest', function ($row) {
                return $row->pinterest ? $row->pinterest : '';
            });
            $table->editColumn('reddit', function ($row) {
                return $row->reddit ? $row->reddit : '';
            });
            $table->editColumn('website', function ($row) {
                return $row->website ? $row->website : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'logo', 'banner']);

            return $table->make(true);
        }

        return view('admin.businessSettings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('business_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.businessSettings.create');
    }

    public function store(StoreBusinessSettingRequest $request)
    {
        $businessSetting = BusinessSetting::create($request->all());

        if ($request->input('logo', false)) {
            $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($request->input('banner', false)) {
            $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $businessSetting->id]);
        }

        return redirect()->route('admin.business-settings.index');
    }

    public function edit(BusinessSetting $businessSetting)
    {
        abort_if(Gate::denies('business_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessSetting->load('team');

        return view('admin.businessSettings.edit', compact('businessSetting'));
    }

    public function update(UpdateBusinessSettingRequest $request, BusinessSetting $businessSetting)
    {
        $businessSetting->update($request->all());

        if ($request->input('logo', false)) {
            if (!$businessSetting->logo || $request->input('logo') !== $businessSetting->logo->file_name) {
                if ($businessSetting->logo) {
                    $businessSetting->logo->delete();
                }
                $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($businessSetting->logo) {
            $businessSetting->logo->delete();
        }

        if ($request->input('banner', false)) {
            if (!$businessSetting->banner || $request->input('banner') !== $businessSetting->banner->file_name) {
                if ($businessSetting->banner) {
                    $businessSetting->banner->delete();
                }
                $businessSetting->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner'))))->toMediaCollection('banner');
            }
        } elseif ($businessSetting->banner) {
            $businessSetting->banner->delete();
        }

        return redirect()->route('admin.business-settings.index');
    }

    public function show(BusinessSetting $businessSetting)
    {
        abort_if(Gate::denies('business_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessSetting->load('team');

        return view('admin.businessSettings.show', compact('businessSetting'));
    }

    public function destroy(BusinessSetting $businessSetting)
    {
        abort_if(Gate::denies('business_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyBusinessSettingRequest $request)
    {
        BusinessSetting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('business_setting_create') && Gate::denies('business_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BusinessSetting();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
