@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.unitQuantity.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-quantities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.unitQuantity.fields.id') }}
                        </th>
                        <td>
                            {{ $unitQuantity->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitQuantity.fields.name') }}
                        </th>
                        <td>
                            {{ $unitQuantity->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitQuantity.fields.metric') }}
                        </th>
                        <td>
                            {{ $unitQuantity->metric }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.unitQuantity.fields.imperial') }}
                        </th>
                        <td>
                            {{ $unitQuantity->imperial }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.unit-quantities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection