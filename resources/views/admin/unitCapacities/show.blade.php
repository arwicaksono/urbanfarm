@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.unitCapacity.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-capacities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.unitCapacity.fields.id') }}
                        </th>
                        <td>
                            {{ $unitCapacity->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitCapacity.fields.name') }}
                        </th>
                        <td>
                            {{ $unitCapacity->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitCapacity.fields.metric') }}
                        </th>
                        <td>
                            {{ $unitCapacity->metric }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitCapacity.fields.imperial') }}
                        </th>
                        <td>
                            {{ $unitCapacity->imperial }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-capacities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection