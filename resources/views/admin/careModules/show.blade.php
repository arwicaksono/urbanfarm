@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careModule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-modules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.id') }}
                        </th>
                        <td>
                            {{ $careModule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.code') }}
                        </th>
                        <td>
                            {{ $careModule->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.number') }}
                        </th>
                        <td>
                            {{ $careModule->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.date') }}
                        </th>
                        <td>
                            {{ $careModule->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.time_start') }}
                        </th>
                        <td>
                            {{ $careModule->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.time_end') }}
                        </th>
                        <td>
                            {{ $careModule->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.problem_mo') }}
                        </th>
                        <td>
                            {{ $careModule->problem_mo->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.action') }}
                        </th>
                        <td>
                            {{ $careModule->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.efficacy') }}
                        </th>
                        <td>
                            {{ $careModule->efficacy->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.status') }}
                        </th>
                        <td>
                            {{ $careModule->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.tag') }}
                        </th>
                        <td>
                            @foreach($careModule->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CareModule::IS_DONE_SELECT[$careModule->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.image') }}
                        </th>
                        <td>
                            @if($careModule->image)
                                <a href="{{ $careModule->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $careModule->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.note') }}
                        </th>
                        <td>
                            {{ $careModule->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careModule.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($careModule->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-modules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection