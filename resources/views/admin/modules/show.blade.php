@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.module.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.modules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.id') }}
                        </th>
                        <td>
                            {{ $module->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.code') }}
                        </th>
                        <td>
                            {{ $module->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.number') }}
                        </th>
                        <td>
                            {{ $module->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.site_code') }}
                        </th>
                        <td>
                            {{ $module->site_code->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.system') }}
                        </th>
                        <td>
                            {{ $module->system->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.lighting') }}
                        </th>
                        <td>
                            {{ $module->lighting->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.reservoir') }}
                        </th>
                        <td>
                            {{ $module->reservoir->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.pump') }}
                        </th>
                        <td>
                            {{ $module->pump->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.mounting') }}
                        </th>
                        <td>
                            {{ $module->mounting->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.capacity') }}
                        </th>
                        <td>
                            {{ $module->capacity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.unit') }}
                        </th>
                        <td>
                            {{ $module->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.acitivity') }}
                        </th>
                        <td>
                            @foreach($module->acitivities as $key => $acitivity)
                                <span class="label label-info">{{ $acitivity->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Module::IS_ACTIVE_SELECT[$module->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.image') }}
                        </th>
                        <td>
                            @foreach($module->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.module.fields.note') }}
                        </th>
                        <td>
                            {{ $module->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.modules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection