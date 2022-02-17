@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careDistribution.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-distributions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.id') }}
                        </th>
                        <td>
                            {{ $careDistribution->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.code') }}
                        </th>
                        <td>
                            {{ $careDistribution->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.number') }}
                        </th>
                        <td>
                            {{ $careDistribution->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.date') }}
                        </th>
                        <td>
                            {{ $careDistribution->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.time_start') }}
                        </th>
                        <td>
                            {{ $careDistribution->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.time_end') }}
                        </th>
                        <td>
                            {{ $careDistribution->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.problem_dist') }}
                        </th>
                        <td>
                            {{ $careDistribution->problem_dist->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.action') }}
                        </th>
                        <td>
                            {{ $careDistribution->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.status') }}
                        </th>
                        <td>
                            {{ $careDistribution->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.tag') }}
                        </th>
                        <td>
                            @foreach($careDistribution->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CareDistribution::IS_DONE_SELECT[$careDistribution->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.image') }}
                        </th>
                        <td>
                            @foreach($careDistribution->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.note') }}
                        </th>
                        <td>
                            {{ $careDistribution->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careDistribution.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($careDistribution->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-distributions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection