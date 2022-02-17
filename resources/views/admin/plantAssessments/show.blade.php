@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plantAssessment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plant-assessments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.id') }}
                        </th>
                        <td>
                            {{ $plantAssessment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.code') }}
                        </th>
                        <td>
                            {{ $plantAssessment->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.number') }}
                        </th>
                        <td>
                            {{ $plantAssessment->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.date') }}
                        </th>
                        <td>
                            {{ $plantAssessment->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.time') }}
                        </th>
                        <td>
                            {{ $plantAssessment->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.plot') }}
                        </th>
                        <td>
                            {{ $plantAssessment->plot->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.age') }}
                        </th>
                        <td>
                            {{ $plantAssessment->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.unit') }}
                        </th>
                        <td>
                            {{ $plantAssessment->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.tag') }}
                        </th>
                        <td>
                            @foreach($plantAssessment->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\PlantAssessment::IS_PROBLEM_SELECT[$plantAssessment->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.priority') }}
                        </th>
                        <td>
                            {{ $plantAssessment->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.image') }}
                        </th>
                        <td>
                            @foreach($plantAssessment->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.note') }}
                        </th>
                        <td>
                            {{ $plantAssessment->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plantAssessment.fields.person_in_charge') }}
                        </th>
                        <td>
                            {{ $plantAssessment->person_in_charge->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plant-assessments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection