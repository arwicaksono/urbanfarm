<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCashflowPurchaseRequest;
use App\Http\Requests\StoreCashflowPurchaseRequest;
use App\Http\Requests\UpdateCashflowPurchaseRequest;
use App\Models\AttPriority;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CashflowPurchase;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CashflowPurchaseController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cashflow_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CashflowPurchase::with(['is_priority', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CashflowPurchase())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cashflow_purchase_show';
                $editGate = 'cashflow_purchase_edit';
                $deleteGate = 'cashflow_purchase_delete';
                $crudRoutePart = 'cashflow-purchases';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('unit_price', function ($row) {
                return $row->unit_price ? $row->unit_price : '';
            });
            $table->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount : '';
            });
            $table->editColumn('total_price', function ($row) {
                return $row->total_price ? $row->total_price : '';
            });
            $table->editColumn('is_expense', function ($row) {
                return $row->is_expense ? CashflowPurchase::IS_EXPENSE_SELECT[$row->is_expense] : '';
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? CashflowPurchase::IS_PROBLEM_SELECT[$row->is_problem] : '';
            });
            $table->addColumn('is_priority_name', function ($row) {
                return $row->is_priority ? $row->is_priority->name : '';
            });

            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
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
            $table->editColumn('person_in_charge', function ($row) {
                $labels = [];
                foreach ($row->person_in_charges as $person_in_charge) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $person_in_charge->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'is_priority', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.cashflowPurchases.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cashflow_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $is_priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.cashflowPurchases.create', compact('is_priorities', 'person_in_charges', 'statuses', 'tags'));
    }

    public function store(StoreCashflowPurchaseRequest $request)
    {
        $cashflowPurchase = CashflowPurchase::create($request->all());
        $cashflowPurchase->tags()->sync($request->input('tags', []));
        $cashflowPurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cashflowPurchase->id]);
        }

        return redirect()->route('admin.cashflow-purchases.index');
    }

    public function edit(CashflowPurchase $cashflowPurchase)
    {
        abort_if(Gate::denies('cashflow_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $is_priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $cashflowPurchase->load('is_priority', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.cashflowPurchases.edit', compact('cashflowPurchase', 'is_priorities', 'person_in_charges', 'statuses', 'tags'));
    }

    public function update(UpdateCashflowPurchaseRequest $request, CashflowPurchase $cashflowPurchase)
    {
        $cashflowPurchase->update($request->all());
        $cashflowPurchase->tags()->sync($request->input('tags', []));
        $cashflowPurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($cashflowPurchase->image) > 0) {
            foreach ($cashflowPurchase->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowPurchase->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.cashflow-purchases.index');
    }

    public function show(CashflowPurchase $cashflowPurchase)
    {
        abort_if(Gate::denies('cashflow_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowPurchase->load('is_priority', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.cashflowPurchases.show', compact('cashflowPurchase'));
    }

    public function destroy(CashflowPurchase $cashflowPurchase)
    {
        abort_if(Gate::denies('cashflow_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowPurchase->delete();

        return back();
    }

    public function massDestroy(MassDestroyCashflowPurchaseRequest $request)
    {
        CashflowPurchase::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cashflow_purchase_create') && Gate::denies('cashflow_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CashflowPurchase();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
