@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.attTag.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.att-tags.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.attTag.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attTag.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="group">{{ trans('cruds.attTag.fields.group') }}</label>
                <input class="form-control {{ $errors->has('group') ? 'is-invalid' : '' }}" type="text" name="group" id="group" value="{{ old('group', '') }}">
                @if($errors->has('group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attTag.fields.group_helper') }}</span>
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