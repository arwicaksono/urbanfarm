<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCashflowSaleRequest;
use App\Http\Requests\StoreCashflowSaleRequest;
use App\Http\Requests\UpdateCashflowSaleRequest;
use App\Models\AttPriority;
use App\Models\AttTag;
use App\Models\CashflowSale;
use App\Models\Packing;
use App\Models\UnitWeight;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CashflowSalesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cashflow_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CashflowSale::with(['packing_code', 'unit', 'tags', 'is_priority', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CashflowSale())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cashflow_sale_show';
                $editGate = 'cashflow_sale_edit';
                $deleteGate = 'cashflow_sale_delete';
                $crudRoutePart = 'cashflow-sales';

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
            $table->addColumn('packing_code_code', function ($row) {
                return $row->packing_code ? $row->packing_code->code : '';
            });

            $table->editColumn('sales_qty', function ($row) {
                return $row->sales_qty ? $row->sales_qty : '';
            });
            $table->addColumn('unit_name', function ($row) {
                return $row->unit ? $row->unit->name : '';
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
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('is_income', function ($row) {
                return $row->is_income ? CashflowSale::IS_INCOME_SELECT[$row->is_income] : '';
            });
            $table->editColumn('is_active', function ($row) {
                return $row->is_active ? CashflowSale::IS_ACTIVE_SELECT[$row->is_active] : '';
            });
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? CashflowSale::IS_PROBLEM_SELECT[$row->is_problem] : '';
            });
            $table->addColumn('is_priority_name', function ($row) {
                return $row->is_priority ? $row->is_priority->name : '';
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

            $table->rawColumns(['actions', 'placeholder', 'packing_code', 'unit', 'tag', 'is_priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.cashflowSales.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cashflow_sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing_codes = Packing::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitWeight::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $is_priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.cashflowSales.create', compact('is_priorities', 'packing_codes', 'person_in_charges', 'tags', 'units'));
    }

    public function store(StoreCashflowSaleRequest $request)
    {
        $cashflowSale = CashflowSale::create($request->all());
        $cashflowSale->tags()->sync($request->input('tags', []));
        $cashflowSale->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cashflowSale->id]);
        }

        return redirect()->route('admin.cashflow-sales.index');
    }

    public function edit(CashflowSale $cashflowSale)
    {
        abort_if(Gate::denies('cashflow_sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing_codes = Packing::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitWeight::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $is_priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        $cashflowSale->load('packing_code', 'unit', 'tags', 'is_priority', 'person_in_charges', 'team');

        return view('admin.cashflowSales.edit', compact('cashflowSale', 'is_priorities', 'packing_codes', 'person_in_charges', 'tags', 'units'));
    }

    public function update(UpdateCashflowSaleRequest $request, CashflowSale $cashflowSale)
    {
        $cashflowSale->update($request->all());
        $cashflowSale->tags()->sync($request->input('tags', []));
        $cashflowSale->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($cashflowSale->image) > 0) {
            foreach ($cashflowSale->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowSale->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.cashflow-sales.index');
    }

    public function show(CashflowSale $cashflowSale)
    {
        abort_if(Gate::denies('cashflow_sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowSale->load('packing_code', 'unit', 'tags', 'is_priority', 'person_in_charges', 'team');

        return view('admin.cashflowSales.show', compact('cashflowSale'));
    }

    public function destroy(CashflowSale $cashflowSale)
    {
        abort_if(Gate::denies('cashflow_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowSale->delete();

        return back();
    }

    public function massDestroy(MassDestroyCashflowSaleRequest $request)
    {
        CashflowSale::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cashflow_sale_create') && Gate::denies('cashflow_sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CashflowSale();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
