@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.distribution.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.distributions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.id') }}
                        </th>
                        <td>
                            {{ $distribution->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.code') }}
                        </th>
                        <td>
                            {{ $distribution->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.number') }}
                        </th>
                        <td>
                            {{ $distribution->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.date') }}
                        </th>
                        <td>
                            {{ $distribution->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.time') }}
                        </th>
                        <td>
                            {{ $distribution->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.packing_code') }}
                        </th>
                        <td>
                            @foreach($distribution->packing_codes as $key => $packing_code)
                                <span class="label label-info">{{ $packing_code->code }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.customer') }}
                        </th>
                        <td>
                            {{ $distribution->customer->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.channel') }}
                        </th>
                        <td>
                            {{ $distribution->channel->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.market') }}
                        </th>
                        <td>
                            {{ $distribution->market->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.delivery') }}
                        </th>
                        <td>
                            {{ $distribution->delivery->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.cost') }}
                        </th>
                        <td>
                            {{ $distribution->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.status') }}
                        </th>
                        <td>
                            {{ $distribution->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.tag') }}
                        </th>
                        <td>
                            @foreach($distribution->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\Distribution::IS_PROBLEM_SELECT[$distribution->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.priority') }}
                        </th>
                        <td>
                            {{ $distribution->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.image') }}
                        </th>
                        <td>
                            @foreach($distribution->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.note') }}
                        </th>
                        <td>
                            {{ $distribution->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.distribution.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($distribution->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.distributions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection