@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adminCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adminCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $adminCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $adminCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminCategory.fields.description') }}
                        </th>
                        <td>
                            {{ $adminCategory->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminCategory.fields.image') }}
                        </th>
                        <td>
                            @if($adminCategory->image)
                                <a href="{{ $adminCategory->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $adminCategory->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection