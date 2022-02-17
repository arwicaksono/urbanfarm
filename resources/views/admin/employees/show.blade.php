@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employee.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.id') }}
                        </th>
                        <td>
                            {{ $employee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.employee_name') }}
                        </th>
                        <td>
                            {{ $employee->employee_name->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.birthdate') }}
                        </th>
                        <td>
                            {{ $employee->birthdate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.address') }}
                        </th>
                        <td>
                            {{ $employee->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $employee->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.position') }}
                        </th>
                        <td>
                            {{ $employee->position->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.status') }}
                        </th>
                        <td>
                            {{ $employee->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.date_start') }}
                        </th>
                        <td>
                            {{ $employee->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.date_end') }}
                        </th>
                        <td>
                            {{ $employee->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.image') }}
                        </th>
                        <td>
                            @if($employee->image)
                                <a href="{{ $employee->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $employee->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.note') }}
                        </th>
                        <td>
                            {{ $employee->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection