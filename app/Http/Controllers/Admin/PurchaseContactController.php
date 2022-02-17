<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPurchaseContactRequest;
use App\Http\Requests\StorePurchaseContactRequest;
use App\Http\Requests\UpdatePurchaseContactRequest;
use App\Models\PurchaseContact;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PurchaseContactController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PurchaseContact::with(['team'])->select(sprintf('%s.*', (new PurchaseContact())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'purchase_contact_show';
                $editGate = 'purchase_contact_edit';
                $deleteGate = 'purchase_contact_delete';
                $crudRoutePart = 'purchase-contacts';

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
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('linkedin', function ($row) {
                return $row->linkedin ? $row->linkedin : '';
            });
            $table->editColumn('twitter', function ($row) {
                return $row->twitter ? $row->twitter : '';
            });
            $table->editColumn('facebook', function ($row) {
                return $row->facebook ? $row->facebook : '';
            });
            $table->editColumn('instagram', function ($row) {
                return $row->instagram ? $row->instagram : '';
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

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.purchaseContacts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('purchase_contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.purchaseContacts.create');
    }

    public function store(StorePurchaseContactRequest $request)
    {
        $purchaseContact = PurchaseContact::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $purchaseContact->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $purchaseContact->id]);
        }

        return redirect()->route('admin.purchase-contacts.index');
    }

    public function edit(PurchaseContact $purchaseContact)
    {
        abort_if(Gate::denies('purchase_contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseContact->load('team');

        return view('admin.purchaseContacts.edit', compact('purchaseContact'));
    }

    public function update(UpdatePurchaseContactRequest $request, PurchaseContact $purchaseContact)
    {
        $purchaseContact->update($request->all());

        if (count($purchaseContact->image) > 0) {
            foreach ($purchaseContact->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $purchaseContact->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $purchaseContact->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.purchase-contacts.index');
    }

    public function show(PurchaseContact $purchaseContact)
    {
        abort_if(Gate::denies('purchase_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseContact->load('team');

        return view('admin.purchaseContacts.show', compact('purchaseContact'));
    }

    public function destroy(PurchaseContact $purchaseContact)
    {
        abort_if(Gate::denies('purchase_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseContact->delete();

        return back();
    }

    public function massDestroy(MassDestroyPurchaseContactRequest $request)
    {
        PurchaseContact::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('purchase_contact_create') && Gate::denies('purchase_contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PurchaseContact();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
