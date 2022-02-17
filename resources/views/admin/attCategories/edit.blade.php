@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.attCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.att-categories.update", [$attCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.attCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $attCategory->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attCategory.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="group">{{ trans('cruds.attCategory.fields.group') }}</label>
                <input class="form-control {{ $errors->has('group') ? 'is-invalid' : '' }}" type="text" name="group" id="group" value="{{ old('group', $attCategory->group) }}">
                @if($errors->has('group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attCategory.fields.group_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection