@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carePacking.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-packings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.id') }}
                        </th>
                        <td>
                            {{ $carePacking->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.code') }}
                        </th>
                        <td>
                            {{ $carePacking->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.number') }}
                        </th>
                        <td>
                            {{ $carePacking->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.date') }}
                        </th>
                        <td>
                            {{ $carePacking->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.time_start') }}
                        </th>
                        <td>
                            {{ $carePacking->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.time_end') }}
                        </th>
                        <td>
                            {{ $carePacking->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.problem_packing') }}
                        </th>
                        <td>
                            {{ $carePacking->problem_packing->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.action') }}
                        </th>
                        <td>
                            {{ $carePacking->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.status') }}
                        </th>
                        <td>
                            {{ $carePacking->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.tag') }}
                        </th>
                        <td>
                            @foreach($carePacking->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CarePacking::IS_DONE_SELECT[$carePacking->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.image') }}
                        </th>
                        <td>
                            @foreach($carePacking->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.note') }}
                        </th>
                        <td>
                            {{ $carePacking->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePacking.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($carePacking->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-packings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection