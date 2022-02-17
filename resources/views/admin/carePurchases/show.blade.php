@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carePurchase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.id') }}
                        </th>
                        <td>
                            {{ $carePurchase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.code') }}
                        </th>
                        <td>
                            {{ $carePurchase->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.number') }}
                        </th>
                        <td>
                            {{ $carePurchase->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.date') }}
                        </th>
                        <td>
                            {{ $carePurchase->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.time_start') }}
                        </th>
                        <td>
                            {{ $carePurchase->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.time_end') }}
                        </th>
                        <td>
                            {{ $carePurchase->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.problem_purchase') }}
                        </th>
                        <td>
                            {{ $carePurchase->problem_purchase->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.action') }}
                        </th>
                        <td>
                            {{ $carePurchase->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.status') }}
                        </th>
                        <td>
                            {{ $carePurchase->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.tag') }}
                        </th>
                        <td>
                            @foreach($carePurchase->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CarePurchase::IS_DONE_SELECT[$carePurchase->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.image') }}
                        </th>
                        <td>
                            @foreach($carePurchase->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.note') }}
                        </th>
                        <td>
                            {{ $carePurchase->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePurchase.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($carePurchase->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection