@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchaseBrand.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-brands.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseBrand->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.name') }}
                        </th>
                        <td>
                            {{ $purchaseBrand->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.company') }}
                        </th>
                        <td>
                            {{ $purchaseBrand->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.category') }}
                        </th>
                        <td>
                            {{ $purchaseBrand->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.tag') }}
                        </th>
                        <td>
                            @foreach($purchaseBrand->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.image') }}
                        </th>
                        <td>
                            @foreach($purchaseBrand->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseBrand.fields.note') }}
                        </th>
                        <td>
                            {{ $purchaseBrand->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-brands.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection