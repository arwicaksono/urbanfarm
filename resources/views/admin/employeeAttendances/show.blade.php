@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeAttendance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeAttendance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.name') }}
                        </th>
                        <td>
                            {{ $employeeAttendance->name->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.date') }}
                        </th>
                        <td>
                            {{ $employeeAttendance->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.arrival') }}
                        </th>
                        <td>
                            {{ $employeeAttendance->arrival }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.departure') }}
                        </th>
                        <td>
                            {{ $employeeAttendance->departure }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.image') }}
                        </th>
                        <td>
                            @foreach($employeeAttendance->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeAttendance.fields.note') }}
                        </th>
                        <td>
                            {{ $employeeAttendance->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection