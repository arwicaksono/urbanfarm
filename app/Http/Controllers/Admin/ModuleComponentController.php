<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyModuleComponentRequest;
use App\Http\Requests\StoreModuleComponentRequest;
use App\Http\Requests\UpdateModuleComponentRequest;
use App\Models\AttCategoryComp;
use App\Models\ModuleComponent;
use App\Models\PurchaseBrand;
use App\Models\PurchaseCompany;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ModuleComponentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('module_component_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ModuleComponent::with(['brand', 'company', 'category', 'team'])->select(sprintf('%s.*', (new ModuleComponent())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'module_component_show';
                $editGate = 'module_component_edit';
                $deleteGate = 'module_component_delete';
                $crudRoutePart = 'module-components';

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
            $table->addColumn('brand_name', function ($row) {
                return $row->brand ? $row->brand->name : '';
            });

            $table->addColumn('company_name', function ($row) {
                return $row->company ? $row->company->name : '';
            });

            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->editColumn('in_use', function ($row) {
                return $row->in_use ? ModuleComponent::IN_USE_SELECT[$row->in_use] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'brand', 'company', 'category', 'image']);

            return $table->make(true);
        }

        return view('admin.moduleComponents.index');
    }

    public function create()
    {
        abort_if(Gate::denies('module_component_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brands = PurchaseBrand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = PurchaseCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategoryComp::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.moduleComponents.create', compact('brands', 'categories', 'companies'));
    }

    public function store(StoreModuleComponentRequest $request)
    {
        $moduleComponent = ModuleComponent::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $moduleComponent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $moduleComponent->id]);
        }

        return redirect()->route('admin.module-components.index');
    }

    public function edit(ModuleComponent $moduleComponent)
    {
        abort_if(Gate::denies('module_component_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brands = PurchaseBrand::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = PurchaseCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategoryComp::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moduleComponent->load('brand', 'company', 'category', 'team');

        return view('admin.moduleComponents.edit', compact('brands', 'categories', 'companies', 'moduleComponent'));
    }

    public function update(UpdateModuleComponentRequest $request, ModuleComponent $moduleComponent)
    {
        $moduleComponent->update($request->all());

        if (count($moduleComponent->image) > 0) {
            foreach ($moduleComponent->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $moduleComponent->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $moduleComponent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.module-components.index');
    }

    public function show(ModuleComponent $moduleComponent)
    {
        abort_if(Gate::denies('module_component_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleComponent->load('brand', 'company', 'category', 'team');

        return view('admin.moduleComponents.show', compact('moduleComponent'));
    }

    public function destroy(ModuleComponent $moduleComponent)
    {
        abort_if(Gate::denies('module_component_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moduleComponent->delete();

        return back();
    }

    public function massDestroy(MassDestroyModuleComponentRequest $request)
    {
        ModuleComponent::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('module_component_create') && Gate::denies('module_component_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ModuleComponent();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
