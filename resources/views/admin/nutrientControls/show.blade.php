@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.nutrientControl.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.nutrient-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.id') }}
                        </th>
                        <td>
                            {{ $nutrientControl->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.code') }}
                        </th>
                        <td>
                            {{ $nutrientControl->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.number') }}
                        </th>
                        <td>
                            {{ $nutrientControl->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.date') }}
                        </th>
                        <td>
                            {{ $nutrientControl->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.time') }}
                        </th>
                        <td>
                            {{ $nutrientControl->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.module') }}
                        </th>
                        <td>
                            {{ $nutrientControl->module->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.ppm') }}
                        </th>
                        <td>
                            {{ $nutrientControl->ppm }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.ec') }}
                        </th>
                        <td>
                            {{ $nutrientControl->ec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.ph') }}
                        </th>
                        <td>
                            {{ $nutrientControl->ph }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.temperature') }}
                        </th>
                        <td>
                            {{ $nutrientControl->temperature }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.tag') }}
                        </th>
                        <td>
                            @foreach($nutrientControl->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\NutrientControl::IS_PROBLEM_SELECT[$nutrientControl->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.priority') }}
                        </th>
                        <td>
                            {{ $nutrientControl->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.image') }}
                        </th>
                        <td>
                            @foreach($nutrientControl->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.note') }}
                        </th>
                        <td>
                            {{ $nutrientControl->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.nutrientControl.fields.person_in_charge') }}
                        </th>
                        <td>
                            {{ $nutrientControl->person_in_charge->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.nutrient-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection