<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCashflowExpenseRequest;
use App\Http\Requests\StoreCashflowExpenseRequest;
use App\Http\Requests\UpdateCashflowExpenseRequest;
use App\Models\AttTag;
use App\Models\CashflowExpense;
use App\Models\CashflowExpenseCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CashflowExpenseController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cashflow_expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CashflowExpense::with(['category', 'tags', 'team'])->select(sprintf('%s.*', (new CashflowExpense())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cashflow_expense_show';
                $editGate = 'cashflow_expense_edit';
                $deleteGate = 'cashflow_expense_delete';
                $crudRoutePart = 'cashflow-expenses';

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

        return view('admin.cashflowExpenses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cashflow_expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CashflowExpenseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        return view('admin.cashflowExpenses.create', compact('categories', 'tags'));
    }

    public function store(StoreCashflowExpenseRequest $request)
    {
        $cashflowExpense = CashflowExpense::create($request->all());
        $cashflowExpense->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $cashflowExpense->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cashflowExpense->id]);
        }

        return redirect()->route('admin.cashflow-expenses.index');
    }

    public function edit(CashflowExpense $cashflowExpense)
    {
        abort_if(Gate::denies('cashflow_expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CashflowExpenseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $cashflowExpense->load('category', 'tags', 'team');

        return view('admin.cashflowExpenses.edit', compact('cashflowExpense', 'categories', 'tags'));
    }

    public function update(UpdateCashflowExpenseRequest $request, CashflowExpense $cashflowExpense)
    {
        $cashflowExpense->update($request->all());
        $cashflowExpense->tags()->sync($request->input('tags', []));
        if (count($cashflowExpense->image) > 0) {
            foreach ($cashflowExpense->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $cashflowExpense->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $cashflowExpense->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.cashflow-expenses.index');
    }

    public function show(CashflowExpense $cashflowExpense)
    {
        abort_if(Gate::denies('cashflow_expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpense->load('category', 'tags', 'team');

        return view('admin.cashflowExpenses.show', compact('cashflowExpense'));
    }

    public function destroy(CashflowExpense $cashflowExpense)
    {
        abort_if(Gate::denies('cashflow_expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cashflowExpense->delete();

        return back();
    }

    public function massDestroy(MassDestroyCashflowExpenseRequest $request)
    {
        CashflowExpense::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cashflow_expense_create') && Gate::denies('cashflow_expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CashflowExpense();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
