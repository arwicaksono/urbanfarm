@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adminPlan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-plans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.id') }}
                        </th>
                        <td>
                            {{ $adminPlan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.title') }}
                        </th>
                        <td>
                            {{ $adminPlan->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.subtitle') }}
                        </th>
                        <td>
                            {{ $adminPlan->subtitle }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.description') }}
                        </th>
                        <td>
                            {!! $adminPlan->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.feature') }}
                        </th>
                        <td>
                            {!! $adminPlan->feature !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.price') }}
                        </th>
                        <td>
                            {{ $adminPlan->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminPlan.fields.discount') }}
                        </th>
                        <td>
                            {{ $adminPlan->discount }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-plans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection