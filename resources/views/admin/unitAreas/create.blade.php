@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.unitArea.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.unit-areas.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.unitArea.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitArea.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="metric">{{ trans('cruds.unitArea.fields.metric') }}</label>
                <input class="form-control {{ $errors->has('metric') ? 'is-invalid' : '' }}" type="text" name="metric" id="metric" value="{{ old('metric', '') }}">
                @if($errors->has('metric'))
                    <div class="invalid-feedback">
                        {{ $errors->first('metric') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitArea.fields.metric_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="imperial">{{ trans('cruds.unitArea.fields.imperial') }}</label>
                <input class="form-control {{ $errors->has('imperial') ? 'is-invalid' : '' }}" type="text" name="imperial" id="imperial" value="{{ old('imperial', '') }}">
                @if($errors->has('imperial'))
                    <div class="invalid-feedback">
                        {{ $errors->first('imperial') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitArea.fields.imperial_helper') }}</span>
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