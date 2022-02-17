<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdminExpertRequest;
use App\Http\Requests\StoreAdminExpertRequest;
use App\Http\Requests\UpdateAdminExpertRequest;
use App\Models\AdminExpert;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminExpertController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_expert_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AdminExpert::query()->select(sprintf('%s.*', (new AdminExpert())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'admin_expert_show';
                $editGate = 'admin_expert_edit';
                $deleteGate = 'admin_expert_delete';
                $crudRoutePart = 'admin-experts';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
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

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.adminExperts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('admin_expert_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminExperts.create');
    }

    public function store(StoreAdminExpertRequest $request)
    {
        $adminExpert = AdminExpert::create($request->all());

        if ($request->input('image', false)) {
            $adminExpert->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $adminExpert->id]);
        }

        return redirect()->route('admin.admin-experts.index');
    }

    public function edit(AdminExpert $adminExpert)
    {
        abort_if(Gate::denies('admin_expert_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminExperts.edit', compact('adminExpert'));
    }

    public function update(UpdateAdminExpertRequest $request, AdminExpert $adminExpert)
    {
        $adminExpert->update($request->all());

        if ($request->input('image', false)) {
            if (!$adminExpert->image || $request->input('image') !== $adminExpert->image->file_name) {
                if ($adminExpert->image) {
                    $adminExpert->image->delete();
                }
                $adminExpert->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($adminExpert->image) {
            $adminExpert->image->delete();
        }

        return redirect()->route('admin.admin-experts.index');
    }

    public function show(AdminExpert $adminExpert)
    {
        abort_if(Gate::denies('admin_expert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminExperts.show', compact('adminExpert'));
    }

    public function destroy(AdminExpert $adminExpert)
    {
        abort_if(Gate::denies('admin_expert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminExpert->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminExpertRequest $request)
    {
        AdminExpert::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('admin_expert_create') && Gate::denies('admin_expert_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AdminExpert();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
