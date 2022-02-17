@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plot.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plots.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.id') }}
                        </th>
                        <td>
                            {{ $plot->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.code') }}
                        </th>
                        <td>
                            {{ $plot->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.number') }}
                        </th>
                        <td>
                            {{ $plot->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.plot_prefix') }}
                        </th>
                        <td>
                            {{ $plot->plot_prefix->prefix ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.activity') }}
                        </th>
                        <td>
                            {{ $plot->activity->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.module') }}
                        </th>
                        <td>
                            {{ $plot->module->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.nutrient_brand') }}
                        </th>
                        <td>
                            {{ $plot->nutrient_brand->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.plot_qty') }}
                        </th>
                        <td>
                            {{ $plot->plot_qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.unit') }}
                        </th>
                        <td>
                            {{ $plot->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.variety') }}
                        </th>
                        <td>
                            {{ $plot->variety->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.date_start') }}
                        </th>
                        <td>
                            {{ $plot->date_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.time_start') }}
                        </th>
                        <td>
                            {{ $plot->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.date_end') }}
                        </th>
                        <td>
                            {{ $plot->date_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.time_end') }}
                        </th>
                        <td>
                            {{ $plot->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.tag') }}
                        </th>
                        <td>
                            @foreach($plot->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Plot::IS_ACTIVE_SELECT[$plot->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.image') }}
                        </th>
                        <td>
                            @foreach($plot->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plot.fields.note') }}
                        </th>
                        <td>
                            {{ $plot->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plots.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection