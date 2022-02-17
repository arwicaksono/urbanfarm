@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carePlantAssessment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-plant-assessments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.id') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.code') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.number') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.date') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.time_start') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.time_end') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.problem_pa') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->problem_pa->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.action') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.efficacy') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->efficacy->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.status') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.tag') }}
                        </th>
                        <td>
                            @foreach($carePlantAssessment->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CarePlantAssessment::IS_DONE_SELECT[$carePlantAssessment->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.image') }}
                        </th>
                        <td>
                            @if($carePlantAssessment->image)
                                <a href="{{ $carePlantAssessment->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $carePlantAssessment->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.note') }}
                        </th>
                        <td>
                            {{ $carePlantAssessment->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePlantAssessment.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($carePlantAssessment->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-plant-assessments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection