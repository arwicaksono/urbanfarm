@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.site.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.id') }}
                        </th>
                        <td>
                            {{ $site->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.code') }}
                        </th>
                        <td>
                            {{ $site->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.number') }}
                        </th>
                        <td>
                            {{ $site->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.name') }}
                        </th>
                        <td>
                            {{ $site->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.location') }}
                        </th>
                        <td>
                            {{ $site->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.elevation') }}
                        </th>
                        <td>
                            {{ $site->elevation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.acreage') }}
                        </th>
                        <td>
                            {{ $site->acreage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.unit') }}
                        </th>
                        <td>
                            {{ $site->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.setting') }}
                        </th>
                        <td>
                            @foreach($site->settings as $key => $setting)
                                <span class="label label-info">{{ $setting->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.water_source') }}
                        </th>
                        <td>
                            @foreach($site->water_sources as $key => $water_source)
                                <span class="label label-info">{{ $water_source->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Site::IS_ACTIVE_SELECT[$site->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.image') }}
                        </th>
                        <td>
                            @foreach($site->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.note') }}
                        </th>
                        <td>
                            {{ $site->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($site->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection