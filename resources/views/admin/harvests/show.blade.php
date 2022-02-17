@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.harvest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.harvests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.id') }}
                        </th>
                        <td>
                            {{ $harvest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.code') }}
                        </th>
                        <td>
                            {{ $harvest->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.number') }}
                        </th>
                        <td>
                            {{ $harvest->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.date') }}
                        </th>
                        <td>
                            {{ $harvest->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.time') }}
                        </th>
                        <td>
                            {{ $harvest->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.plot') }}
                        </th>
                        <td>
                            {{ $harvest->plot->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.age') }}
                        </th>
                        <td>
                            {{ $harvest->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.unit') }}
                        </th>
                        <td>
                            {{ $harvest->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.round') }}
                        </th>
                        <td>
                            {{ $harvest->round }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.grade') }}
                        </th>
                        <td>
                            @foreach($harvest->grades as $key => $grade)
                                <span class="label label-info">{{ $grade->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.harvest_qty') }}
                        </th>
                        <td>
                            {{ $harvest->harvest_qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.harvest_unit') }}
                        </th>
                        <td>
                            {{ $harvest->harvest_unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.status') }}
                        </th>
                        <td>
                            {{ $harvest->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.tag') }}
                        </th>
                        <td>
                            @foreach($harvest->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Harvest::IS_ACTIVE_SELECT[$harvest->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\Harvest::IS_PROBLEM_SELECT[$harvest->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.priority') }}
                        </th>
                        <td>
                            {{ $harvest->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.image') }}
                        </th>
                        <td>
                            @foreach($harvest->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.note') }}
                        </th>
                        <td>
                            {{ $harvest->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.harvest.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($harvest->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.harvests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection