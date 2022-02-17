<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\EmployeeStatus;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Employee::with(['employee_name', 'position', 'status', 'team'])->select(sprintf('%s.*', (new Employee())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_show';
                $editGate = 'employee_edit';
                $deleteGate = 'employee_delete';
                $crudRoutePart = 'employees';

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
            $table->addColumn('employee_name_name', function ($row) {
                return $row->employee_name ? $row->employee_name->name : '';
            });

            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });
            $table->addColumn('position_name', function ($row) {
                return $row->position ? $row->position->name : '';
            });

            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('note', function ($row) {
                return $row->note ? $row->note : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee_name', 'position', 'status', 'image']);

            return $table->make(true);
        }

        return view('admin.employees.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee_names = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $positions = EmployeePosition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = EmployeeStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employees.create', compact('employee_names', 'positions', 'statuses'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        if ($request->input('image', false)) {
            $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employee->id]);
        }

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee_names = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $positions = EmployeePosition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = EmployeeStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employee->load('employee_name', 'position', 'status', 'team');

        return view('admin.employees.edit', compact('employee', 'employee_names', 'positions', 'statuses'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        if ($request->input('image', false)) {
            if (!$employee->image || $request->input('image') !== $employee->image->file_name) {
                if ($employee->image) {
                    $employee->image->delete();
                }
                $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($employee->image) {
            $employee->image->delete();
        }

        return redirect()->route('admin.employees.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('employee_name', 'position', 'status', 'team');

        return view('admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_create') && Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Employee();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
