@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adminSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $adminSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.name') }}
                        </th>
                        <td>
                            {{ $adminSetting->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.subtitle') }}
                        </th>
                        <td>
                            {{ $adminSetting->subtitle }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.copyright') }}
                        </th>
                        <td>
                            {{ $adminSetting->copyright }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.logo') }}
                        </th>
                        <td>
                            @if($adminSetting->logo)
                                <a href="{{ $adminSetting->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $adminSetting->logo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.dark_mode') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $adminSetting->dark_mode ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.rtl') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $adminSetting->rtl ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminSetting.fields.description') }}
                        </th>
                        <td>
                            {!! $adminSetting->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection