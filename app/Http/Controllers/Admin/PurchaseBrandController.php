<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPurchaseBrandRequest;
use App\Http\Requests\StorePurchaseBrandRequest;
use App\Http\Requests\UpdatePurchaseBrandRequest;
use App\Models\AttCategory;
use App\Models\AttTag;
use App\Models\PurchaseBrand;
use App\Models\PurchaseCompany;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PurchaseBrandController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_brand_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PurchaseBrand::with(['company', 'category', 'tags', 'team'])->select(sprintf('%s.*', (new PurchaseBrand())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'purchase_brand_show';
                $editGate = 'purchase_brand_edit';
                $deleteGate = 'purchase_brand_delete';
                $crudRoutePart = 'purchase-brands';

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
            $table->addColumn('company_name', function ($row) {
                return $row->company ? $row->company->name : '';
            });

            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
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

            $table->rawColumns(['actions', 'placeholder', 'company', 'category', 'tag', 'image']);

            return $table->make(true);
        }

        return view('admin.purchaseBrands.index');
    }

    public function create()
    {
        abort_if(Gate::denies('purchase_brand_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = PurchaseCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        return view('admin.purchaseBrands.create', compact('categories', 'companies', 'tags'));
    }

    public function store(StorePurchaseBrandRequest $request)
    {
        $purchaseBrand = PurchaseBrand::create($request->all());
        $purchaseBrand->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $purchaseBrand->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $purchaseBrand->id]);
        }

        return redirect()->route('admin.purchase-brands.index');
    }

    public function edit(PurchaseBrand $purchaseBrand)
    {
        abort_if(Gate::denies('purchase_brand_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = PurchaseCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $purchaseBrand->load('company', 'category', 'tags', 'team');

        return view('admin.purchaseBrands.edit', compact('categories', 'companies', 'purchaseBrand', 'tags'));
    }

    public function update(UpdatePurchaseBrandRequest $request, PurchaseBrand $purchaseBrand)
    {
        $purchaseBrand->update($request->all());
        $purchaseBrand->tags()->sync($request->input('tags', []));
        if (count($purchaseBrand->image) > 0) {
            foreach ($purchaseBrand->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseBrand->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseBrand->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.purchase-brands.index');
    }

    public function show(PurchaseBrand $purchaseBrand)
    {
        abort_if(Gate::denies('purchase_brand_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseBrand->load('company', 'category', 'tags', 'team');

        return view('admin.purchaseBrands.show', compact('purchaseBrand'));
    }

    public function destroy(PurchaseBrand $purchaseBrand)
    {
        abort_if(Gate::denies('purchase_brand_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseBrand->delete();

        return back();
    }

    public function massDestroy(MassDestroyPurchaseBrandRequest $request)
    {
        PurchaseBrand::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('purchase_brand_create') && Gate::denies('purchase_brand_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PurchaseBrand();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
