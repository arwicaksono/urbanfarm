@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careNutrientControl.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-nutrient-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.id') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.code') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.number') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.date') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.time_start') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.time_end') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.problem_nc') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->problem_nc->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.action') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.efficacy') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->efficacy->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.status') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.tag') }}
                        </th>
                        <td>
                            @foreach($careNutrientControl->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CareNutrientControl::IS_DONE_SELECT[$careNutrientControl->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.image') }}
                        </th>
                        <td>
                            @if($careNutrientControl->image)
                                <a href="{{ $careNutrientControl->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $careNutrientControl->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.note') }}
                        </th>
                        <td>
                            {{ $careNutrientControl->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careNutrientControl.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($careNutrientControl->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-nutrient-controls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection