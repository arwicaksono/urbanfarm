@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moduleObservation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.module-observations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.id') }}
                        </th>
                        <td>
                            {{ $moduleObservation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.code') }}
                        </th>
                        <td>
                            {{ $moduleObservation->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.number') }}
                        </th>
                        <td>
                            {{ $moduleObservation->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.date') }}
                        </th>
                        <td>
                            {{ $moduleObservation->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.time') }}
                        </th>
                        <td>
                            {{ $moduleObservation->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.module') }}
                        </th>
                        <td>
                            {{ $moduleObservation->module->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.component') }}
                        </th>
                        <td>
                            @foreach($moduleObservation->components as $key => $component)
                                <span class="label label-info">{{ $component->code }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.tag') }}
                        </th>
                        <td>
                            @foreach($moduleObservation->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\ModuleObservation::IS_PROBLEM_SELECT[$moduleObservation->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.priority') }}
                        </th>
                        <td>
                            {{ $moduleObservation->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.image') }}
                        </th>
                        <td>
                            @foreach($moduleObservation->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.note') }}
                        </th>
                        <td>
                            {{ $moduleObservation->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleObservation.fields.person_in_charge') }}
                        </th>
                        <td>
                            {{ $moduleObservation->person_in_charge->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.module-observations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection