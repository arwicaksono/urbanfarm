<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeAttendanceRequest;
use App\Http\Requests\StoreEmployeeAttendanceRequest;
use App\Http\Requests\UpdateEmployeeAttendanceRequest;
use App\Models\EmployeeAttendance;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeAttendanceController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeAttendance::with(['name', 'team'])->select(sprintf('%s.*', (new EmployeeAttendance())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_attendance_show';
                $editGate = 'employee_attendance_edit';
                $deleteGate = 'employee_attendance_delete';
                $crudRoutePart = 'employee-attendances';

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
            $table->addColumn('name_name', function ($row) {
                return $row->name ? $row->name->name : '';
            });

            $table->editColumn('arrival', function ($row) {
                return $row->arrival ? $row->arrival : '';
            });
            $table->editColumn('departure', function ($row) {
                return $row->departure ? $row->departure : '';
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

            $table->rawColumns(['actions', 'placeholder', 'name', 'image']);

            return $table->make(true);
        }

        return view('admin.employeeAttendances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $names = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeAttendances.create', compact('names'));
    }

    public function store(StoreEmployeeAttendanceRequest $request)
    {
        $employeeAttendance = EmployeeAttendance::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $employeeAttendance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employeeAttendance->id]);
        }

        return redirect()->route('admin.employee-attendances.index');
    }

    public function edit(EmployeeAttendance $employeeAttendance)
    {
        abort_if(Gate::denies('employee_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $names = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeAttendance->load('name', 'team');

        return view('admin.employeeAttendances.edit', compact('employeeAttendance', 'names'));
    }

    public function update(UpdateEmployeeAttendanceRequest $request, EmployeeAttendance $employeeAttendance)
    {
        $employeeAttendance->update($request->all());

        if (count($employeeAttendance->image) > 0) {
            foreach ($employeeAttendance->image as $media) {
                if (!in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $employeeAttendance->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $employeeAttendance->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        return redirect()->route('admin.employee-attendances.index');
    }

    public function show(EmployeeAttendance $employeeAttendance)
    {
        abort_if(Gate::denies('employee_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAttendance->load('name', 'team');

        return view('admin.employeeAttendances.show', compact('employeeAttendance'));
    }

    public function destroy(EmployeeAttendance $employeeAttendance)
    {
        abort_if(Gate::denies('employee_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeAttendanceRequest $request)
    {
        EmployeeAttendance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_attendance_create') && Gate::denies('employee_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EmployeeAttendance();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
