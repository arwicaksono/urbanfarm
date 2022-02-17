@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeJobDesc.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-job-descs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeJobDesc.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeJobDesc->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeJobDesc.fields.position') }}
                        </th>
                        <td>
                            {{ $employeeJobDesc->position->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeJobDesc.fields.detail') }}
                        </th>
                        <td>
                            {!! $employeeJobDesc->detail !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeJobDesc.fields.note') }}
                        </th>
                        <td>
                            {{ $employeeJobDesc->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-job-descs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection