@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchaseSubstance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-substances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.code') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.number') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.name') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.category') }}
                        </th>
                        <td>
                            @foreach($purchaseSubstance->categories as $key => $category)
                                <span class="label label-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.tag') }}
                        </th>
                        <td>
                            @foreach($purchaseSubstance->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.brand') }}
                        </th>
                        <td>
                            @foreach($purchaseSubstance->brands as $key => $brand)
                                <span class="label label-info">{{ $brand->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.quantity') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.unit') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.image') }}
                        </th>
                        <td>
                            @foreach($purchaseSubstance->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseSubstance.fields.note') }}
                        </th>
                        <td>
                            {{ $purchaseSubstance->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-substances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection