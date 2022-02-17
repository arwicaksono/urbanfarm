@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.empLeaveType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emp-leave-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.empLeaveType.fields.id') }}
                        </th>
                        <td>
                            {{ $empLeaveType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.empLeaveType.fields.name') }}
                        </th>
                        <td>
                            {{ $empLeaveType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.empLeaveType.fields.notes') }}
                        </th>
                        <td>
                            {{ $empLeaveType->notes }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emp-leave-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection