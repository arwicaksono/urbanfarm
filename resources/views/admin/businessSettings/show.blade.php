@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.businessSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.business-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $businessSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.name') }}
                        </th>
                        <td>
                            {{ $businessSetting->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.logo') }}
                        </th>
                        <td>
                            @if($businessSetting->logo)
                                <a href="{{ $businessSetting->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $businessSetting->logo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.banner') }}
                        </th>
                        <td>
                            @if($businessSetting->banner)
                                <a href="{{ $businessSetting->banner->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $businessSetting->banner->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.address') }}
                        </th>
                        <td>
                            {{ $businessSetting->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.email') }}
                        </th>
                        <td>
                            {{ $businessSetting->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.phone') }}
                        </th>
                        <td>
                            {{ $businessSetting->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.whatsapp') }}
                        </th>
                        <td>
                            {{ $businessSetting->whatsapp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.telegram') }}
                        </th>
                        <td>
                            {{ $businessSetting->telegram }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.facebook') }}
                        </th>
                        <td>
                            {{ $businessSetting->facebook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.twitter') }}
                        </th>
                        <td>
                            {{ $businessSetting->twitter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.instagram') }}
                        </th>
                        <td>
                            {{ $businessSetting->instagram }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.linked_in') }}
                        </th>
                        <td>
                            {{ $businessSetting->linked_in }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.youtube') }}
                        </th>
                        <td>
                            {{ $businessSetting->youtube }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.pinterest') }}
                        </th>
                        <td>
                            {{ $businessSetting->pinterest }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.reddit') }}
                        </th>
                        <td>
                            {{ $businessSetting->reddit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessSetting.fields.website') }}
                        </th>
                        <td>
                            {{ $businessSetting->website }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.business-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection