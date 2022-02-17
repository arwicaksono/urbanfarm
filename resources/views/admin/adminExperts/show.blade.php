@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adminExpert.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-experts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adminExpert.fields.id') }}
                        </th>
                        <td>
                            {{ $adminExpert->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminExpert.fields.name') }}
                        </th>
                        <td>
                            {{ $adminExpert->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminExpert.fields.title') }}
                        </th>
                        <td>
                            {{ $adminExpert->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminExpert.fields.description') }}
                        </th>
                        <td>
                            {!! $adminExpert->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminExpert.fields.image') }}
                        </th>
                        <td>
                            @if($adminExpert->image)
                                <a href="{{ $adminExpert->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $adminExpert->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-experts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection