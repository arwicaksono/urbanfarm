<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDistributionRequest;
use App\Http\Requests\StoreDistributionRequest;
use App\Http\Requests\UpdateDistributionRequest;
use App\Models\AttPriority;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\Distribution;
use App\Models\Packing;
use App\Models\SalesChannel;
use App\Models\SalesCustomer;
use App\Models\SalesDelivery;
use App\Models\SalesMarket;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DistributionController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Distribution::with(['packing_codes', 'customer', 'channel', 'market', 'delivery', 'status', 'tags', 'priority', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new Distribution())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'distribution_show';
                $editGate = 'distribution_edit';
                $deleteGate = 'distribution_delete';
                $crudRoutePart = 'distributions';

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
            $table->editColumn('packing_code', function ($row) {
                $labels = [];
                foreach ($row->packing_codes as $packing_code) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $packing_code->code);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('customer_code', function ($row) {
                return $row->customer ? $row->customer->code : '';
            });

            $table->addColumn('channel_name', function ($row) {
                return $row->channel ? $row->channel->name : '';
            });

            $table->addColumn('market_name', function ($row) {
                return $row->market ? $row->market->name : '';
            });

            $table->addColumn('delivery_name', function ($row) {
                return $row->delivery ? $row->delivery->name : '';
            });

            $table->editColumn('cost', function ($row) {
                return $row->cost ? $row->cost : '';
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
            $table->editColumn('is_problem', function ($row) {
                return $row->is_problem ? Distribution::IS_PROBLEM_SELECT[$row->is_problem] : '';
            });
            $table->addColumn('priority_name', function ($row) {
                return $row->priority ? $row->priority->name : '';
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

            $table->rawColumns(['actions', 'placeholder', 'packing_code', 'customer', 'channel', 'market', 'delivery', 'status', 'tag', 'priority', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.distributions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing_codes = Packing::pluck('code', 'id');

        $customers = SalesCustomer::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = SalesChannel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $markets = SalesMarket::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deliveries = SalesDelivery::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.distributions.create', compact('channels', 'customers', 'deliveries', 'markets', 'packing_codes', 'person_in_charges', 'priorities', 'statuses', 'tags'));
    }

    public function store(StoreDistributionRequest $request)
    {
        $distribution = Distribution::create($request->all());
        $distribution->packing_codes()->sync($request->input('packing_codes', []));
        $distribution->tags()->sync($request->input('tags', []));
        $distribution->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $distribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $distribution->id]);
        }

        return redirect()->route('admin.distributions.index');
    }

    public function edit(Distribution $distribution)
    {
        abort_if(Gate::denies('distribution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $packing_codes = Packing::pluck('code', 'id');

        $customers = SalesCustomer::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = SalesChannel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $markets = SalesMarket::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deliveries = SalesDelivery::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $priorities = AttPriority::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $person_in_charges = User::pluck('name', 'id');

        $distribution->load('packing_codes', 'customer', 'channel', 'market', 'delivery', 'status', 'tags', 'priority', 'person_in_charges', 'team');

        return view('admin.distributions.edit', compact('channels', 'customers', 'deliveries', 'distribution', 'markets', 'packing_codes', 'person_in_charges', 'priorities', 'statuses', 'tags'));
    }

    public function update(UpdateDistributionRequest $request, Distribution $distribution)
    {
        $distribution->update($request->all());
        $distribution->packing_codes()->sync($request->input('packing_codes', []));
        $distribution->tags()->sync($request->input('tags', []));
        $distribution->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($distribution->image) > 0) {
            foreach ($distribution->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $distribution->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $distribution->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.distributions.index');
    }

    public function show(Distribution $distribution)
    {
        abort_if(Gate::denies('distribution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $distribution->load('packing_codes', 'customer', 'channel', 'market', 'delivery', 'status', 'tags', 'priority', 'person_in_charges', 'team');

        return view('admin.distributions.show', compact('distribution'));
    }

    public function destroy(Distribution $distribution)
    {
        abort_if(Gate::denies('distribution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $distribution->delete();

        return back();
    }

    public function massDestroy(MassDestroyDistributionRequest $request)
    {
        Distribution::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('distribution_create') && Gate::denies('distribution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Distribution();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
