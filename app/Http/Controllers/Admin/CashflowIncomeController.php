<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCashflowIncomeRequest;
use App\Http\Requests\StoreCashflowIncomeRequest;
use App\Http\Requests\UpdateCashflowIncomeRequest;
use App\Models\AttTag;
use App\Models\CashflowIncome;
use App\Models\CashflowIncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CashflowIncomeController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cashflow_income_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CashflowIncome::with(['category', 'tags', 'team'])->select(sprintf('%s.*', (new CashflowIncome())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cashflow_income_show';
                $editGate = 'cashflow_income_edit';
                $deleteGate = 'cashflow_income_delete';
                $crudRoutePart = 'cashflow-incomes';

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
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : '';
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

            $table->rawColumns(['actions', 'placeholder', 'category', 'tag', 'image']);

            return $table->make(true);
        }

        return view('admin.cashflowIncomes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cashflow_income_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CashflowIncomeCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        return view('admin.cashflowIncomes.create', compact('categories', 'tags'));
    }

    public function store(StoreCashflowIncomeRequest $request)
    {
        $cashflowIncome = CashflowIncome::create($request->all());
        $cashflowIncome->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowIncome->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cashflowIncome->id]);
        }

        return redirect()->route('admin.cashflow-incomes.index');
    }

    public function edit(CashflowIncome $cashflowIncome)
    {
        abort_if(Gate::denies('cashflow_income_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CashflowIncomeCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $cashflowIncome->load('category', 'tags', 'team');

        return view('admin.cashflowIncomes.edit', compact('cashflowIncome', 'categories', 'tags'));
    }

    public function update(UpdateCashflowIncomeRequest $request, CashflowIncome $cashflowIncome)
    {
        $cashflowIncome->update($request->all());
        $cashflowIncome->tags()->sync($request->input('tags', []));
        if (count($cashflowIncome->image) > 0) {
            foreach ($cashflowIncome->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowIncome->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowIncome->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.cashflow-incomes.index');
    }

    public function show(CashflowIncome $cashflowIncome)
    {
        abort_if(Gate::denies('cashflow_income_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncome->load('category', 'tags', 'team');

        return view('admin.cashflowIncomes.show', compact('cashflowIncome'));
    }

    public function destroy(CashflowIncome $cashflowIncome)
    {
        abort_if(Gate::denies('cashflow_income_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowIncome->delete();

        return back();
    }

    public function massDestroy(MassDestroyCashflowIncomeRequest $request)
    {
        CashflowIncome::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cashflow_income_create') && Gate::denies('cashflow_income_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CashflowIncome();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
