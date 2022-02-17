<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPurchaseCompanyRequest;
use App\Http\Requests\StorePurchaseCompanyRequest;
use App\Http\Requests\UpdatePurchaseCompanyRequest;
use App\Models\AttCategory;
use App\Models\PurchaseCompany;
use App\Models\PurchaseContact;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PurchaseCompanyController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PurchaseCompany::with(['contact_person', 'category', 'team'])->select(sprintf('%s.*', (new PurchaseCompany())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'purchase_company_show';
                $editGate = 'purchase_company_edit';
                $deleteGate = 'purchase_company_delete';
                $crudRoutePart = 'purchase-companies';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
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
            $table->addColumn('contact_person_name', function ($row) {
                return $row->contact_person ? $row->contact_person->name : '';
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
            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'contact_person', 'image', 'category']);

            return $table->make(true);
        }

        return view('admin.purchaseCompanies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('purchase_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contact_people = PurchaseContact::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.purchaseCompanies.create', compact('categories', 'contact_people'));
    }

    public function store(StorePurchaseCompanyRequest $request)
    {
        $purchaseCompany = PurchaseCompany::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $purchaseCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $purchaseCompany->id]);
        }

        return redirect()->route('admin.purchase-companies.index');
    }

    public function edit(PurchaseCompany $purchaseCompany)
    {
        abort_if(Gate::denies('purchase_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contact_people = PurchaseContact::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AttCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $purchaseCompany->load('contact_person', 'category', 'team');

        return view('admin.purchaseCompanies.edit', compact('categories', 'contact_people', 'purchaseCompany'));
    }

    public function update(UpdatePurchaseCompanyRequest $request, PurchaseCompany $purchaseCompany)
    {
        $purchaseCompany->update($request->all());

        if (count($purchaseCompany->image) > 0) {
            foreach ($purchaseCompany->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseCompany->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.purchase-companies.index');
    }

    public function show(PurchaseCompany $purchaseCompany)
    {
        abort_if(Gate::denies('purchase_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseCompany->load('contact_person', 'category', 'team');

        return view('admin.purchaseCompanies.show', compact('purchaseCompany'));
    }

    public function destroy(PurchaseCompany $purchaseCompany)
    {
        abort_if(Gate::denies('purchase_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroyPurchaseCompanyRequest $request)
    {
        PurchaseCompany::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('purchase_company_create') && Gate::denies('purchase_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PurchaseCompany();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
