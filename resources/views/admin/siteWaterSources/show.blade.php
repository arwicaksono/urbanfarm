@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.siteWaterSource.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.site-water-sources.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.siteWaterSource.fields.id') }}
                        </th>
                        <td>
                            {{ $siteWaterSource->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.siteWaterSource.fields.name') }}
                        </th>
                        <td>
                            {{ $siteWaterSource->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.site-water-sources.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection