@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careSale.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-sales.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.id') }}
                        </th>
                        <td>
                            {{ $careSale->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.code') }}
                        </th>
                        <td>
                            {{ $careSale->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.number') }}
                        </th>
                        <td>
                            {{ $careSale->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.date') }}
                        </th>
                        <td>
                            {{ $careSale->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.time_start') }}
                        </th>
                        <td>
                            {{ $careSale->time_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.time_end') }}
                        </th>
                        <td>
                            {{ $careSale->time_end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.problem_sale') }}
                        </th>
                        <td>
                            {{ $careSale->problem_sale->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.action') }}
                        </th>
                        <td>
                            {{ $careSale->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.status') }}
                        </th>
                        <td>
                            {{ $careSale->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.tag') }}
                        </th>
                        <td>
                            @foreach($careSale->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CareSale::IS_DONE_SELECT[$careSale->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.image') }}
                        </th>
                        <td>
                            @foreach($careSale->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.note') }}
                        </th>
                        <td>
                            {{ $careSale->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careSale.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($careSale->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-sales.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection