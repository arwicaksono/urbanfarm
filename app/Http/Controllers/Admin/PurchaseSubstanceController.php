<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPurchaseSubstanceRequest;
use App\Http\Requests\StorePurchaseSubstanceRequest;
use App\Http\Requests\UpdatePurchaseSubstanceRequest;
use App\Models\AttCategory;
use App\Models\AttTag;
use App\Models\PurchaseBrand;
use App\Models\PurchaseSubstance;
use App\Models\UnitWeight;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PurchaseSubstanceController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_substance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PurchaseSubstance::with(['categories', 'tags', 'brands', 'unit', 'team'])->select(sprintf('%s.*', (new PurchaseSubstance())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'purchase_substance_show';
                $editGate = 'purchase_substance_edit';
                $deleteGate = 'purchase_substance_delete';
                $crudRoutePart = 'purchase-substances';

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
            $table->editColumn('category', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('brand', function ($row) {
                $labels = [];
                foreach ($row->brands as $brand) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $brand->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
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

            $table->rawColumns(['actions', 'placeholder', 'category', 'tag', 'brand', 'unit', 'image']);

            return $table->make(true);
        }

        return view('admin.purchaseSubstances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('purchase_substance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = AttCategory::pluck('name', 'id');

        $tags = AttTag::pluck('name', 'id');

        $brands = PurchaseBrand::pluck('name', 'id');

        $units = UnitWeight::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.purchaseSubstances.create', compact('brands', 'categories', 'tags', 'units'));
    }

    public function store(StorePurchaseSubstanceRequest $request)
    {
        $purchaseSubstance = PurchaseSubstance::create($request->all());
        $purchaseSubstance->categories()->sync($request->input('categories', []));
        $purchaseSubstance->tags()->sync($request->input('tags', []));
        $purchaseSubstance->brands()->sync($request->input('brands', []));
        foreach ($request->input('image', []) as $file) {
            $purchaseSubstance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $purchaseSubstance->id]);
        }

        return redirect()->route('admin.purchase-substances.index');
    }

    public function edit(PurchaseSubstance $purchaseSubstance)
    {
        abort_if(Gate::denies('purchase_substance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = AttCategory::pluck('name', 'id');

        $tags = AttTag::pluck('name', 'id');

        $brands = PurchaseBrand::pluck('name', 'id');

        $units = UnitWeight::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $purchaseSubstance->load('categories', 'tags', 'brands', 'unit', 'team');

        return view('admin.purchaseSubstances.edit', compact('brands', 'categories', 'purchaseSubstance', 'tags', 'units'));
    }

    public function update(UpdatePurchaseSubstanceRequest $request, PurchaseSubstance $purchaseSubstance)
    {
        $purchaseSubstance->update($request->all());
        $purchaseSubstance->categories()->sync($request->input('categories', []));
        $purchaseSubstance->tags()->sync($request->input('tags', []));
        $purchaseSubstance->brands()->sync($request->input('brands', []));
        if (count($purchaseSubstance->image) > 0) {
            foreach ($purchaseSubstance->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseSubstance->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseSubstance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.purchase-substances.index');
    }

    public function show(PurchaseSubstance $purchaseSubstance)
    {
        abort_if(Gate::denies('purchase_substance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseSubstance->load('categories', 'tags', 'brands', 'unit', 'team');

        return view('admin.purchaseSubstances.show', compact('purchaseSubstance'));
    }

    public function destroy(PurchaseSubstance $purchaseSubstance)
    {
        abort_if(Gate::denies('purchase_substance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseSubstance->delete();

        return back();
    }

    public function massDestroy(MassDestroyPurchaseSubstanceRequest $request)
    {
        PurchaseSubstance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('purchase_substance_create') && Gate::denies('purchase_substance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PurchaseSubstance();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
