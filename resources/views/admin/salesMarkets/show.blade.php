@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.salesMarket.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-markets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.id') }}
                        </th>
                        <td>
                            {{ $salesMarket->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.code') }}
                        </th>
                        <td>
                            {{ $salesMarket->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.number') }}
                        </th>
                        <td>
                            {{ $salesMarket->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.name') }}
                        </th>
                        <td>
                            {{ $salesMarket->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.channel') }}
                        </th>
                        <td>
                            {{ $salesMarket->channel->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.payment') }}
                        </th>
                        <td>
                            {{ $salesMarket->payment->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.address') }}
                        </th>
                        <td>
                            {{ $salesMarket->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.website') }}
                        </th>
                        <td>
                            {{ $salesMarket->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.email') }}
                        </th>
                        <td>
                            {{ $salesMarket->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.phone') }}
                        </th>
                        <td>
                            {{ $salesMarket->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.tag') }}
                        </th>
                        <td>
                            @foreach($salesMarket->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.image') }}
                        </th>
                        <td>
                            @foreach($salesMarket->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesMarket.fields.note') }}
                        </th>
                        <td>
                            {{ $salesMarket->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-markets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection