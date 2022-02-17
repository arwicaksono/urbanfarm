@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adminInfo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-infos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.id') }}
                        </th>
                        <td>
                            {{ $adminInfo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.code') }}
                        </th>
                        <td>
                            {{ $adminInfo->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.start') }}
                        </th>
                        <td>
                            {{ $adminInfo->start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.end') }}
                        </th>
                        <td>
                            {{ $adminInfo->end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.title') }}
                        </th>
                        <td>
                            {{ $adminInfo->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.description') }}
                        </th>
                        <td>
                            {!! $adminInfo->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.other') }}
                        </th>
                        <td>
                            {!! $adminInfo->other !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.image') }}
                        </th>
                        <td>
                            @if($adminInfo->image)
                                <a href="{{ $adminInfo->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $adminInfo->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminInfo.fields.note') }}
                        </th>
                        <td>
                            {!! $adminInfo->note !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-infos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection