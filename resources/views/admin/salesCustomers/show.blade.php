@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.salesCustomer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.id') }}
                        </th>
                        <td>
                            {{ $salesCustomer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.code') }}
                        </th>
                        <td>
                            {{ $salesCustomer->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.number') }}
                        </th>
                        <td>
                            {{ $salesCustomer->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.name') }}
                        </th>
                        <td>
                            {{ $salesCustomer->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.address') }}
                        </th>
                        <td>
                            {{ $salesCustomer->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.status') }}
                        </th>
                        <td>
                            {{ $salesCustomer->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.category') }}
                        </th>
                        <td>
                            @foreach($salesCustomer->categories as $key => $category)
                                <span class="label label-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.tag') }}
                        </th>
                        <td>
                            @foreach($salesCustomer->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.phone') }}
                        </th>
                        <td>
                            {{ $salesCustomer->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.email') }}
                        </th>
                        <td>
                            {{ $salesCustomer->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.website') }}
                        </th>
                        <td>
                            {{ $salesCustomer->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.image') }}
                        </th>
                        <td>
                            @foreach($salesCustomer->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesCustomer.fields.note') }}
                        </th>
                        <td>
                            {{ $salesCustomer->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection