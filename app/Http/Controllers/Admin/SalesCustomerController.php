<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySalesCustomerRequest;
use App\Http\Requests\StoreSalesCustomerRequest;
use App\Http\Requests\UpdateSalesCustomerRequest;
use App\Models\AttCategory;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\SalesCustomer;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesCustomerController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sales_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SalesCustomer::with(['status', 'categories', 'tags', 'team'])->select(sprintf('%s.*', (new SalesCustomer())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sales_customer_show';
                $editGate = 'sales_customer_edit';
                $deleteGate = 'sales_customer_delete';
                $crudRoutePart = 'sales-customers';

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
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
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
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('website', function ($row) {
                return $row->website ? $row->website : '';
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

            $table->rawColumns(['actions', 'placeholder', 'status', 'category', 'tag', 'image']);

            return $table->make(true);
        }

        return view('admin.salesCustomers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sales_customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id');

        $tags = AttTag::pluck('name', 'id');

        return view('admin.salesCustomers.create', compact('categories', 'statuses', 'tags'));
    }

    public function store(StoreSalesCustomerRequest $request)
    {
        $salesCustomer = SalesCustomer::create($request->all());
        $salesCustomer->categories()->sync($request->input('categories', []));
        $salesCustomer->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $salesCustomer->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $salesCustomer->id]);
        }

        return redirect()->route('admin.sales-customers.index');
    }

    public function edit(SalesCustomer $salesCustomer)
    {
        abort_if(Gate::denies('sales_customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id');

        $tags = AttTag::pluck('name', 'id');

        $salesCustomer->load('status', 'categories', 'tags', 'team');

        return view('admin.salesCustomers.edit', compact('categories', 'salesCustomer', 'statuses', 'tags'));
    }

    public function update(UpdateSalesCustomerRequest $request, SalesCustomer $salesCustomer)
    {
        $salesCustomer->update($request->all());
        $salesCustomer->categories()->sync($request->input('categories', []));
        $salesCustomer->tags()->sync($request->input('tags', []));
        if (count($salesCustomer->image) > 0) {
            foreach ($salesCustomer->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $salesCustomer->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $salesCustomer->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.sales-customers.index');
    }

    public function show(SalesCustomer $salesCustomer)
    {
        abort_if(Gate::denies('sales_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesCustomer->load('status', 'categories', 'tags', 'team');

        return view('admin.salesCustomers.show', compact('salesCustomer'));
    }

    public function destroy(SalesCustomer $salesCustomer)
    {
        abort_if(Gate::denies('sales_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesCustomer->delete();

        return back();
    }

    public function massDestroy(MassDestroySalesCustomerRequest $request)
    {
        SalesCustomer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('sales_customer_create') && Gate::denies('sales_customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SalesCustomer();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
