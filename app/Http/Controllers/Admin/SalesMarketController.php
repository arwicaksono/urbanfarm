<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySalesMarketRequest;
use App\Http\Requests\StoreSalesMarketRequest;
use App\Http\Requests\UpdateSalesMarketRequest;
use App\Models\AttTag;
use App\Models\SalesChannel;
use App\Models\SalesMarket;
use App\Models\SalesPayment;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SalesMarketController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sales_market_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SalesMarket::with(['channel', 'payment', 'tags', 'team'])->select(sprintf('%s.*', (new SalesMarket())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sales_market_show';
                $editGate = 'sales_market_edit';
                $deleteGate = 'sales_market_delete';
                $crudRoutePart = 'sales-markets';

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
            $table->addColumn('channel_name', function ($row) {
                return $row->channel ? $row->channel->name : '';
            });

            $table->addColumn('payment_name', function ($row) {
                return $row->payment ? $row->payment->name : '';
            });

            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('website', function ($row) {
                return $row->website ? $row->website : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
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

            $table->rawColumns(['actions', 'placeholder', 'channel', 'payment', 'tag', 'image']);

            return $table->make(true);
        }

        return view('admin.salesMarkets.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sales_market_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = SalesChannel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payments = SalesPayment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        return view('admin.salesMarkets.create', compact('channels', 'payments', 'tags'));
    }

    public function store(StoreSalesMarketRequest $request)
    {
        $salesMarket = SalesMarket::create($request->all());
        $salesMarket->tags()->sync($request->input('tags', []));
        foreach ($request->input('image', []) as $file) {
            $salesMarket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $salesMarket->id]);
        }

        return redirect()->route('admin.sales-markets.index');
    }

    public function edit(SalesMarket $salesMarket)
    {
        abort_if(Gate::denies('sales_market_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = SalesChannel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payments = SalesPayment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $salesMarket->load('channel', 'payment', 'tags', 'team');

        return view('admin.salesMarkets.edit', compact('channels', 'payments', 'salesMarket', 'tags'));
    }

    public function update(UpdateSalesMarketRequest $request, SalesMarket $salesMarket)
    {
        $salesMarket->update($request->all());
        $salesMarket->tags()->sync($request->input('tags', []));
        if (count($salesMarket->image) > 0) {
            foreach ($salesMarket->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $salesMarket->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $salesMarket->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.sales-markets.index');
    }

    public function show(SalesMarket $salesMarket)
    {
        abort_if(Gate::denies('sales_market_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesMarket->load('channel', 'payment', 'tags', 'team');

        return view('admin.salesMarkets.show', compact('salesMarket'));
    }

    public function destroy(SalesMarket $salesMarket)
    {
        abort_if(Gate::denies('sales_market_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salesMarket->delete();

        return back();
    }

    public function massDestroy(MassDestroySalesMarketRequest $request)
    {
        SalesMarket::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('sales_market_create') && Gate::denies('sales_market_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SalesMarket();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
