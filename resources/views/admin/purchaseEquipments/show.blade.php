@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchaseEquipment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-equipments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.code') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.number') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.name') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.quantity') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->unit_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.source') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->source->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.category') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.tag') }}
                        </th>
                        <td>
                            @foreach($purchaseEquipment->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.status') }}
                        </th>
                        <td>
                            @foreach($purchaseEquipment->statuses as $key => $status)
                                <span class="label label-info">{{ $status->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.image') }}
                        </th>
                        <td>
                            @foreach($purchaseEquipment->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseEquipment.fields.note') }}
                        </th>
                        <td>
                            {{ $purchaseEquipment->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-equipments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection