@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchaseCompany.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.name') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.address') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.phone') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.email') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.website') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.contact_person') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->contact_person->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.image') }}
                        </th>
                        <td>
                            @foreach($purchaseCompany->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.category') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseCompany.fields.note') }}
                        </th>
                        <td>
                            {{ $purchaseCompany->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection