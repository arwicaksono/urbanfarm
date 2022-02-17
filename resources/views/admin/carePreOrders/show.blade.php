@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carePreOrder.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-pre-orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.id') }}
                        </th>
                        <td>
                            {{ $carePreOrder->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.code') }}
                        </th>
                        <td>
                            {{ $carePreOrder->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.number') }}
                        </th>
                        <td>
                            {{ $carePreOrder->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.date') }}
                        </th>
                        <td>
                            {{ $carePreOrder->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.time') }}
                        </th>
                        <td>
                            {{ $carePreOrder->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.customer') }}
                        </th>
                        <td>
                            {{ $carePreOrder->customer->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.product') }}
                        </th>
                        <td>
                            {{ $carePreOrder->product->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.qty') }}
                        </th>
                        <td>
                            {{ $carePreOrder->qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.unit') }}
                        </th>
                        <td>
                            {{ $carePreOrder->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.date_due') }}
                        </th>
                        <td>
                            {{ $carePreOrder->date_due }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.time_due') }}
                        </th>
                        <td>
                            {{ $carePreOrder->time_due }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.tag') }}
                        </th>
                        <td>
                            @foreach($carePreOrder->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.priority') }}
                        </th>
                        <td>
                            {{ $carePreOrder->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.date_delivery') }}
                        </th>
                        <td>
                            {{ $carePreOrder->date_delivery }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.time_delivery') }}
                        </th>
                        <td>
                            {{ $carePreOrder->time_delivery }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.payment') }}
                        </th>
                        <td>
                            {{ App\Models\CarePreOrder::PAYMENT_SELECT[$carePreOrder->payment] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.is_done') }}
                        </th>
                        <td>
                            {{ App\Models\CarePreOrder::IS_DONE_SELECT[$carePreOrder->is_done] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.image') }}
                        </th>
                        <td>
                            @foreach($carePreOrder->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.note') }}
                        </th>
                        <td>
                            {{ $carePreOrder->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carePreOrder.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($carePreOrder->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.care-pre-orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection