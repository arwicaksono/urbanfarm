<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPurchaseEquipmentRequest;
use App\Http\Requests\StorePurchaseEquipmentRequest;
use App\Http\Requests\UpdatePurchaseEquipmentRequest;
use App\Models\AttCategory;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\PurchaseCompany;
use App\Models\PurchaseEquipment;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PurchaseEquipmentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_equipment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PurchaseEquipment::with(['source', 'category', 'tags', 'statuses', 'team'])->select(sprintf('%s.*', (new PurchaseEquipment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'purchase_equipment_show';
                $editGate = 'purchase_equipment_edit';
                $deleteGate = 'purchase_equipment_delete';
                $crudRoutePart = 'purchase-equipments';

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
            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('unit_price', function ($row) {
                return $row->unit_price ? $row->unit_price : '';
            });
            $table->addColumn('source_name', function ($row) {
                return $row->source ? $row->source->name : '';
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
            $table->editColumn('status', function ($row) {
                $labels = [];
                foreach ($row->statuses as $status) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $status->name);
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

            $table->rawColumns(['actions', 'placeholder', 'source', 'category', 'tag', 'status', 'image']);

            return $table->make(true);
        }

        return view('admin.purchaseEquipments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('purchase_equipment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sources = PurchaseCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $statuses = AttStatus::pluck('name', 'id');

        return view('admin.purchaseEquipments.create', compact('categories', 'sources', 'statuses', 'tags'));
    }

    public function store(StorePurchaseEquipmentRequest $request)
    {
        $purchaseEquipment = PurchaseEquipment::create($request->all());
        $purchaseEquipment->tags()->sync($request->input('tags', []));
        $purchaseEquipment->statuses()->sync($request->input('statuses', []));
        foreach ($request->input('image', []) as $file) {
            $purchaseEquipment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $purchaseEquipment->id]);
        }

        return redirect()->route('admin.purchase-equipments.index');
    }

    public function edit(PurchaseEquipment $purchaseEquipment)
    {
        abort_if(Gate::denies('purchase_equipment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sources = PurchaseCompany::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $statuses = AttStatus::pluck('name', 'id');

        $purchaseEquipment->load('source', 'category', 'tags', 'statuses', 'team');

        return view('admin.purchaseEquipments.edit', compact('categories', 'purchaseEquipment', 'sources', 'statuses', 'tags'));
    }

    public function update(UpdatePurchaseEquipmentRequest $request, PurchaseEquipment $purchaseEquipment)
    {
        $purchaseEquipment->update($request->all());
        $purchaseEquipment->tags()->sync($request->input('tags', []));
        $purchaseEquipment->statuses()->sync($request->input('statuses', []));
        if (count($purchaseEquipment->image) > 0) {
            foreach ($purchaseEquipment->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseEquipment->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseEquipment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.purchase-equipments.index');
    }

    public function show(PurchaseEquipment $purchaseEquipment)
    {
        abort_if(Gate::denies('purchase_equipment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseEquipment->load('source', 'category', 'tags', 'statuses', 'team');

        return view('admin.purchaseEquipments.show', compact('purchaseEquipment'));
    }

    public function destroy(PurchaseEquipment $purchaseEquipment)
    {
        abort_if(Gate::denies('purchase_equipment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseEquipment->delete();

        return back();
    }

    public function massDestroy(MassDestroyPurchaseEquipmentRequest $request)
    {
        PurchaseEquipment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('purchase_equipment_create') && Gate::denies('purchase_equipment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PurchaseEquipment();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
