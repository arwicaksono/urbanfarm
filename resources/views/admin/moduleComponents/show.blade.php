@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moduleComponent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.module-components.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.id') }}
                        </th>
                        <td>
                            {{ $moduleComponent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.code') }}
                        </th>
                        <td>
                            {{ $moduleComponent->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.number') }}
                        </th>
                        <td>
                            {{ $moduleComponent->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.brand') }}
                        </th>
                        <td>
                            {{ $moduleComponent->brand->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.company') }}
                        </th>
                        <td>
                            {{ $moduleComponent->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.category') }}
                        </th>
                        <td>
                            {{ $moduleComponent->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.in_use') }}
                        </th>
                        <td>
                            {{ App\Models\ModuleComponent::IN_USE_SELECT[$moduleComponent->in_use] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.image') }}
                        </th>
                        <td>
                            @foreach($moduleComponent->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moduleComponent.fields.note') }}
                        </th>
                        <td>
                            {{ $moduleComponent->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.module-components.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection