@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeLeave.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-leaves.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeLeave.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeLeave->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeLeave.fields.name') }}
                        </th>
                        <td>
                            {{ $employeeLeave->name->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeLeave.fields.leave_type') }}
                        </th>
                        <td>
                            {{ $employeeLeave->leave_type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeLeave.fields.date_start') }}
                        </th>
                        <td>
                            {{ $employeeLeave->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeLeave.fields.date_end') }}
                        </th>
                        <td>
                            {{ $employeeLeave->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeLeave.fields.note') }}
                        </th>
                        <td>
                            {{ $employeeLeave->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-leaves.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection