@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchaseContact.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseContact->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.name') }}
                        </th>
                        <td>
                            {{ $purchaseContact->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.phone') }}
                        </th>
                        <td>
                            {{ $purchaseContact->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.address') }}
                        </th>
                        <td>
                            {{ $purchaseContact->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.email') }}
                        </th>
                        <td>
                            {{ $purchaseContact->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.linkedin') }}
                        </th>
                        <td>
                            {{ $purchaseContact->linkedin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.twitter') }}
                        </th>
                        <td>
                            {{ $purchaseContact->twitter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.facebook') }}
                        </th>
                        <td>
                            {{ $purchaseContact->facebook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.instagram') }}
                        </th>
                        <td>
                            {{ $purchaseContact->instagram }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.image') }}
                        </th>
                        <td>
                            @foreach($purchaseContact->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchaseContact.fields.note') }}
                        </th>
                        <td>
                            {{ $purchaseContact->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchase-contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection