@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.unitWeight.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-weights.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.unitWeight.fields.id') }}
                        </th>
                        <td>
                            {{ $unitWeight->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitWeight.fields.name') }}
                        </th>
                        <td>
                            {{ $unitWeight->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitWeight.fields.metric') }}
                        </th>
                        <td>
                            {{ $unitWeight->metric }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitWeight.fields.imperial') }}
                        </th>
                        <td>
                            {{ $unitWeight->imperial }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-weights.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection