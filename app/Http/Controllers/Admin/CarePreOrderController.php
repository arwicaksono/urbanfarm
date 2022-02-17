<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarePreOrderRequest;
use App\Http\Requests\StoreCarePreOrderRequest;
use App\Http\Requests\UpdateCarePreOrderRequest;
use App\Models\AttPriority;
use App\Models\AttTag;
use App\Models\CarePreOrder;
use App\Models\PlotPlant;
use App\Models\SalesCustomer;
use App\Models\UnitQuantity;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CarePreOrderController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_pre_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CarePreOrder::with(['customer', 'product', 'unit', 'tags', 'priority', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CarePreOrder())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_pre_order_show';
                $editGate = 'care_pre_order_edit';
                $deleteGate = 'care_pre_order_delete';
                $crudRoutePart = 'care-pre-orders';

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
            $table->addColumn('customer_code', function ($row) {
                return $row->customer ? $row->customer->code : '';
            });

            $table->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->name : '';
            });

            $table->editColumn('qty', function ($row) {
                return $row->qty ? $row->qty : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
            });

            $table->editColumn('time_due', function ($row) {
                return $row->time_due ? $row->time_due : '';
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('priority_name', function ($row) {
                return $row->priority ? $row->priority->name : '';
            });

            $table->editColumn('time_delivery', function ($row) {
                return $row->time_delivery ? $row->time_delivery : '';
            });
            $table->editColumn('payment', function ($row) {
                return $row->payment ? CarePreOrder::PAYMENT_SELECT[$row->payment] : '';
            });
            $table->editColumn('is_done', function ($row) {
                return $row->is_done ? CarePreOrder::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'customer', 'product', 'unit', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.carePreOrders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_pre_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = SalesCustomer::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = PlotPlant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.carePreOrders.create', compact('customers', 'person_in_charges', 'priorities', 'products', 'tags', 'units'));
    }

    public function store(StoreCarePreOrderRequest $request)
    {
        $carePreOrder = CarePreOrder::create($request->all());
        $carePreOrder->tags()->sync($request->input('tags', []));
        $carePreOrder->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $carePreOrder->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carePreOrder->id]);
        }

        return redirect()->route('admin.care-pre-orders.index');
    }

    public function edit(CarePreOrder $carePreOrder)
    {
        abort_if(Gate::denies('care_pre_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = SalesCustomer::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = PlotPlant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitQuantity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        $carePreOrder->load('customer', 'product', 'unit', 'tags', 'priority', 'person_in_charges', 'team');

        return view('admin.carePreOrders.edit', compact('carePreOrder', 'customers', 'person_in_charges', 'priorities', 'products', 'tags', 'units'));
    }

    public function update(UpdateCarePreOrderRequest $request, CarePreOrder $carePreOrder)
    {
        $carePreOrder->update($request->all());
        $carePreOrder->tags()->sync($request->input('tags', []));
        $carePreOrder->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($carePreOrder->image) > 0) {
            foreach ($carePreOrder->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carePreOrder->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $carePreOrder->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.care-pre-orders.index');
    }

    public function show(CarePreOrder $carePreOrder)
    {
        abort_if(Gate::denies('care_pre_order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePreOrder->load('customer', 'product', 'unit', 'tags', 'priority', 'person_in_charges', 'team');

        return view('admin.carePreOrders.show', compact('carePreOrder'));
    }

    public function destroy(CarePreOrder $carePreOrder)
    {
        abort_if(Gate::denies('care_pre_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePreOrder->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarePreOrderRequest $request)
    {
        CarePreOrder::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_pre_order_create') && Gate::denies('care_pre_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CarePreOrder();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
