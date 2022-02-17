@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.siteInspection.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.site-inspections.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.id') }}
                        </th>
                        <td>
                            {{ $siteInspection->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.code') }}
                        </th>
                        <td>
                            {{ $siteInspection->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.number') }}
                        </th>
                        <td>
                            {{ $siteInspection->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.date') }}
                        </th>
                        <td>
                            {{ $siteInspection->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.time') }}
                        </th>
                        <td>
                            {{ $siteInspection->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.site') }}
                        </th>
                        <td>
                            {{ $siteInspection->site->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.temperature') }}
                        </th>
                        <td>
                            {{ $siteInspection->temperature }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.humidity') }}
                        </th>
                        <td>
                            {{ $siteInspection->humidity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.weather') }}
                        </th>
                        <td>
                            {{ $siteInspection->weather->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.tag') }}
                        </th>
                        <td>
                            @foreach($siteInspection->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\SiteInspection::IS_PROBLEM_SELECT[$siteInspection->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.priority') }}
                        </th>
                        <td>
                            {{ $siteInspection->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.image') }}
                        </th>
                        <td>
                            @foreach($siteInspection->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.note') }}
                        </th>
                        <td>
                            {{ $siteInspection->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteInspection.fields.person_in_charge') }}
                        </th>
                        <td>
                            {{ $siteInspection->person_in_charge->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.site-inspections.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection