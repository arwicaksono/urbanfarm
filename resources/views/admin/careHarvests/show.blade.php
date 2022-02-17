@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careHarvest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-harvests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.id') }}
                        </th>
                        <td>
                            {{ $careHarvest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.code') }}
                        </th>
                        <td>
                            {{ $careHarvest->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.number') }}
                        </th>
                        <td>
                            {{ $careHarvest->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.date') }}
                        </th>
                        <td>
                            {{ $careHarvest->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.time_start') }}
                        </th>
                        <td>
                            {{ $careHarvest->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.time_end') }}
                        </th>
                        <td>
                            {{ $careHarvest->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.problem_harvest') }}
                        </th>
                        <td>
                            {{ $careHarvest->problem_harvest->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.action') }}
                        </th>
                        <td>
                            {{ $careHarvest->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.status') }}
                        </th>
                        <td>
                            {{ $careHarvest->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.tag') }}
                        </th>
                        <td>
                            @foreach($careHarvest->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CareHarvest::IS_DONE_SELECT[$careHarvest->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.image') }}
                        </th>
                        <td>
                            @foreach($careHarvest->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.note') }}
                        </th>
                        <td>
                            {{ $careHarvest->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careHarvest.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($careHarvest->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-harvests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection