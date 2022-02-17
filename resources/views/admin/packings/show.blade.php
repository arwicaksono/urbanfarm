@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.packing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.packings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.id') }}
                        </th>
                        <td>
                            {{ $packing->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.code') }}
                        </th>
                        <td>
                            {{ $packing->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.number') }}
                        </th>
                        <td>
                            {{ $packing->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.date') }}
                        </th>
                        <td>
                            {{ $packing->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.time') }}
                        </th>
                        <td>
                            {{ $packing->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.harvest_code') }}
                        </th>
                        <td>
                            @foreach($packing->harvest_codes as $key => $harvest_code)
                                <span class="label label-info">{{ $harvest_code->code }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.status') }}
                        </th>
                        <td>
                            {{ $packing->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.tag') }}
                        </th>
                        <td>
                            @foreach($packing->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Packing::IS_ACTIVE_SELECT[$packing->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\Packing::IS_PROBLEM_SELECT[$packing->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.priority') }}
                        </th>
                        <td>
                            {{ $packing->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.image') }}
                        </th>
                        <td>
                            @foreach($packing->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.note') }}
                        </th>
                        <td>
                            {{ $packing->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.packing.fields.person_in_charge') }}
                        </th>
                        <td>
                            {{ $packing->person_in_charge->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.packings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection