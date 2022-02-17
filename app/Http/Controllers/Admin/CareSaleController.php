<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCareSaleRequest;
use App\Http\Requests\StoreCareSaleRequest;
use App\Http\Requests\UpdateCareSaleRequest;
use App\Models\AttStatus;
use App\Models\AttTag;
use App\Models\CareSale;
use App\Models\CashflowSale;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CareSaleController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('care_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CareSale::with(['problem_sale', 'status', 'tags', 'person_in_charges', 'team'])->select(sprintf('%s.*', (new CareSale())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'care_sale_show';
                $editGate = 'care_sale_edit';
                $deleteGate = 'care_sale_delete';
                $crudRoutePart = 'care-sales';

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
            $table->addColumn('problem_sale_code', function ($row) {
                return $row->problem_sale ? $row->problem_sale->code : '';
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
                return $row->is_done ? CareSale::IS_DONE_SELECT[$row->is_done] : '';
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

            $table->rawColumns(['actions', 'placeholder', 'problem_sale', 'status', 'tag', 'image', 'person_in_charge']);

            return $table->make(true);
        }

        return view('admin.careSales.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_sales = CashflowSale::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        return view('admin.careSales.create', compact('person_in_charges', 'problem_sales', 'statuses', 'tags'));
    }

    public function store(StoreCareSaleRequest $request)
    {
        $careSale = CareSale::create($request->all());
        $careSale->tags()->sync($request->input('tags', []));
        $careSale->person_in_charges()->sync($request->input('person_in_charges', []));
        foreach ($request->input('image', []) as $file) {
            $careSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $careSale->id]);
        }

        return redirect()->route('admin.care-sales.index');
    }

    public function edit(CareSale $careSale)
    {
        abort_if(Gate::denies('care_sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $problem_sales = CashflowSale::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AttStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = AttTag::pluck('name', 'id');

        $person_in_charges = User::pluck('name', 'id');

        $careSale->load('problem_sale', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careSales.edit', compact('careSale', 'person_in_charges', 'problem_sales', 'statuses', 'tags'));
    }

    public function update(UpdateCareSaleRequest $request, CareSale $careSale)
    {
        $careSale->update($request->all());
        $careSale->tags()->sync($request->input('tags', []));
        $careSale->person_in_charges()->sync($request->input('person_in_charges', []));
        if (count($careSale->image) > 0) {
            foreach ($careSale->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $careSale->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $careSale->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.care-sales.index');
    }

    public function show(CareSale $careSale)
    {
        abort_if(Gate::denies('care_sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careSale->load('problem_sale', 'status', 'tags', 'person_in_charges', 'team');

        return view('admin.careSales.show', compact('careSale'));
    }

    public function destroy(CareSale $careSale)
    {
        abort_if(Gate::denies('care_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careSale->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareSaleRequest $request)
    {
        CareSale::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('care_sale_create') && Gate::denies('care_sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CareSale();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
