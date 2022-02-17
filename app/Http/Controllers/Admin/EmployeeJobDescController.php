<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeJobDescRequest;
use App\Http\Requests\StoreEmployeeJobDescRequest;
use App\Http\Requests\UpdateEmployeeJobDescRequest;
use App\Models\EmployeeJobDesc;
use App\Models\EmployeePosition;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeJobDescController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_job_desc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeJobDesc::with(['position', 'team'])->select(sprintf('%s.*', (new EmployeeJobDesc())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_job_desc_show';
                $editGate = 'employee_job_desc_edit';
                $deleteGate = 'employee_job_desc_delete';
                $crudRoutePart = 'employee-job-descs';

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
            $table->addColumn('position_name', function ($row) {
                return $row->position ? $row->position->name : '';
            });

            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'position']);

            return $table->make(true);
        }

        return view('admin.employeeJobDescs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_job_desc_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $positions = EmployeePosition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeJobDescs.create', compact('positions'));
    }

    public function store(StoreEmployeeJobDescRequest $request)
    {
        $employeeJobDesc = EmployeeJobDesc::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employeeJobDesc->id]);
        }

        return redirect()->route('admin.employee-job-descs.index');
    }

    public function edit(EmployeeJobDesc $employeeJobDesc)
    {
        abort_if(Gate::denies('employee_job_desc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $positions = EmployeePosition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeJobDesc->load('position', 'team');

        return view('admin.employeeJobDescs.edit', compact('employeeJobDesc', 'positions'));
    }

    public function update(UpdateEmployeeJobDescRequest $request, EmployeeJobDesc $employeeJobDesc)
    {
        $employeeJobDesc->update($request->all());

        return redirect()->route('admin.employee-job-descs.index');
    }

    public function show(EmployeeJobDesc $employeeJobDesc)
    {
        abort_if(Gate::denies('employee_job_desc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeJobDesc->load('position', 'team');

        return view('admin.employeeJobDescs.show', compact('employeeJobDesc'));
    }

    public function destroy(EmployeeJobDesc $employeeJobDesc)
    {
        abort_if(Gate::denies('employee_job_desc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeJobDesc->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeJobDescRequest $request)
    {
        EmployeeJobDesc::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_job_desc_create') && Gate::denies('employee_job_desc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EmployeeJobDesc();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
