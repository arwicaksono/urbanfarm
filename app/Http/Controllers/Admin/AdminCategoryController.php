<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdminCategoryRequest;
use App\Http\Requests\StoreAdminCategoryRequest;
use App\Http\Requests\UpdateAdminCategoryRequest;
use App\Models\AdminCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminCategoryController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AdminCategory::query()->select(sprintf('%s.*', (new AdminCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'admin_category_show';
                $editGate = 'admin_category_edit';
                $deleteGate = 'admin_category_delete';
                $crudRoutePart = 'admin-categories';

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
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
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

        return view('admin.adminCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('admin_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminCategories.create');
    }

    public function store(StoreAdminCategoryRequest $request)
    {
        $adminCategory = AdminCategory::create($request->all());

        if ($request->input('image', false)) {
            $adminCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $adminCategory->id]);
        }

        return redirect()->route('admin.admin-categories.index');
    }

    public function edit(AdminCategory $adminCategory)
    {
        abort_if(Gate::denies('admin_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminCategories.edit', compact('adminCategory'));
    }

    public function update(UpdateAdminCategoryRequest $request, AdminCategory $adminCategory)
    {
        $adminCategory->update($request->all());

        if ($request->input('image', false)) {
            if (!$adminCategory->image || $request->input('image') !== $adminCategory->image->file_name) {
                if ($adminCategory->image) {
                    $adminCategory->image->delete();
                }
                $adminCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($adminCategory->image) {
            $adminCategory->image->delete();
        }

        return redirect()->route('admin.admin-categories.index');
    }

    public function show(AdminCategory $adminCategory)
    {
        abort_if(Gate::denies('admin_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adminCategories.show', compact('adminCategory'));
    }

    public function destroy(AdminCategory $adminCategory)
    {
        abort_if(Gate::denies('admin_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adminCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminCategoryRequest $request)
    {
        AdminCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('admin_category_create') && Gate::denies('admin_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AdminCategory();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
