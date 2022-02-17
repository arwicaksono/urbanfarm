@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adminDatabase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-databases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.id') }}
                        </th>
                        <td>
                            {{ $adminDatabase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.image') }}
                        </th>
                        <td>
                            @foreach($adminDatabase->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.title') }}
                        </th>
                        <td>
                            {{ $adminDatabase->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.subtitle') }}
                        </th>
                        <td>
                            {{ $adminDatabase->subtitle }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.description') }}
                        </th>
                        <td>
                            {!! $adminDatabase->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.cause') }}
                        </th>
                        <td>
                            {!! $adminDatabase->cause !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.prevention') }}
                        </th>
                        <td>
                            {!! $adminDatabase->prevention !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.treatment') }}
                        </th>
                        <td>
                            {!! $adminDatabase->treatment !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.recommendation') }}
                        </th>
                        <td>
                            {!! $adminDatabase->recommendation !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.tag') }}
                        </th>
                        <td>
                            @foreach($adminDatabase->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.source') }}
                        </th>
                        <td>
                            {!! $adminDatabase->source !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.admin-databases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection