@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.unitWeight.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.unit-weights.update", [$unitWeight->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.unitWeight.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $unitWeight->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitWeight.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="metric">{{ trans('cruds.unitWeight.fields.metric') }}</label>
                <input class="form-control {{ $errors->has('metric') ? 'is-invalid' : '' }}" type="text" name="metric" id="metric" value="{{ old('metric', $unitWeight->metric) }}">
                @if($errors->has('metric'))
                    <div class="invalid-feedback">
                        {{ $errors->first('metric') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitWeight.fields.metric_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="imperial">{{ trans('cruds.unitWeight.fields.imperial') }}</label>
                <input class="form-control {{ $errors->has('imperial') ? 'is-invalid' : '' }}" type="text" name="imperial" id="imperial" value="{{ old('imperial', $unitWeight->imperial) }}">
                @if($errors->has('imperial'))
                    <div class="invalid-feedback">
                        {{ $errors->first('imperial') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitWeight.fields.imperial_helper') }}</span>
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