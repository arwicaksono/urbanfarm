<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarePurchaseRequest;
use App\Http\Requests\StoreCarePurchaseRequest;
use App\Http\Requests\UpdateCarePurchaseRequest;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CarePurchase;
use App\Models\CashflowPurchase;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CarePurchaseController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CarePurchase::with(['problem_purchase', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CarePurchase())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_purchase_show';
                $editGate = 'care_purchase_edit';
                $deleteGate = 'care_purchase_delete';
                $crudRoutePart = 'care-purchases';

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
            $table->addColumn('problem_purchase_code', function ($row) {
                return $row->problem_purchase ? $row->problem_purchase->code : '';
            });

            $table->editColumn('action', function ($row) {
                return $row->action ? $row->action : '';
            });

            $table->editColumn('time_start', function ($row) {
                return $row->time_start ? $row->time_start : '';
            });
            $table->editColumn('time_end', function ($row) {
                return $row->time_end ? $row->time_end : '';
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
            $table->editColumn('is_done', function ($row) {
                return $row->is_done ? CarePurchase::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'problem_purchase', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.carePurchases.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_purchases = CashflowPurchase::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.carePurchases.create', compact('person_in_charges', 'problem_purchases', 'statuses', 'tags'));
    }

    public function store(StoreCarePurchaseRequest $request)
    {
        $carePurchase = CarePurchase::create($request->all());
        $carePurchase->tags()->sync($request->input('tags', []));
        $carePurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $carePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carePurchase->id]);
        }

        return redirect()->route('admin.care-purchases.index');
    }

    public function edit(CarePurchase $carePurchase)
    {
        abort_if(Gate::denies('care_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_purchases = CashflowPurchase::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $carePurchase->load('problem_purchase', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.carePurchases.edit', compact('carePurchase', 'person_in_charges', 'problem_purchases', 'statuses', 'tags'));
    }

    public function update(UpdateCarePurchaseRequest $request, CarePurchase $carePurchase)
    {
        $carePurchase->update($request->all());
        $carePurchase->tags()->sync($request->input('tags', []));
        $carePurchase->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($carePurchase->image) > 0) {
            foreach ($carePurchase->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carePurchase->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $carePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.care-purchases.index');
    }

    public function show(CarePurchase $carePurchase)
    {
        abort_if(Gate::denies('care_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePurchase->load('problem_purchase', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.carePurchases.show', compact('carePurchase'));
    }

    public function destroy(CarePurchase $carePurchase)
    {
        abort_if(Gate::denies('care_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carePurchase->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarePurchaseRequest $request)
    {
        CarePurchase::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_purchase_create') && Gate::denies('care_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CarePurchase();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
