@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careSite.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-sites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.id') }}
                        </th>
                        <td>
                            {{ $careSite->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.code') }}
                        </th>
                        <td>
                            {{ $careSite->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.number') }}
                        </th>
                        <td>
                            {{ $careSite->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.date') }}
                        </th>
                        <td>
                            {{ $careSite->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.time_start') }}
                        </th>
                        <td>
                            {{ $careSite->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.time_end') }}
                        </th>
                        <td>
                            {{ $careSite->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.problem_si') }}
                        </th>
                        <td>
                            {{ $careSite->problem_si->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.action') }}
                        </th>
                        <td>
                            {{ $careSite->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.efficacy') }}
                        </th>
                        <td>
                            {{ $careSite->efficacy->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.status') }}
                        </th>
                        <td>
                            {{ $careSite->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.tag') }}
                        </th>
                        <td>
                            @foreach($careSite->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CareSite::IS_DONE_SELECT[$careSite->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.image') }}
                        </th>
                        <td>
                            @if($careSite->image)
                                <a href="{{ $careSite->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $careSite->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.note') }}
                        </th>
                        <td>
                            {{ $careSite->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSite.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($careSite->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-sites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection