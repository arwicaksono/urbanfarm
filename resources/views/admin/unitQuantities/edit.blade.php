@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.unitQuantity.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.unit-quantities.update", [$unitQuantity->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.unitQuantity.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $unitQuantity->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitQuantity.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="metric">{{ trans('cruds.unitQuantity.fields.metric') }}</label>
                <input class="form-control {{ $errors->has('metric') ? 'is-invalid' : '' }}" type="text" name="metric" id="metric" value="{{ old('metric', $unitQuantity->metric) }}">
                @if($errors->has('metric'))
                    <div class="invalid-feedback">
                        {{ $errors->first('metric') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitQuantity.fields.metric_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="imperial">{{ trans('cruds.unitQuantity.fields.imperial') }}</label>
                <input class="form-control {{ $errors->has('imperial') ? 'is-invalid' : '' }}" type="text" name="imperial" id="imperial" value="{{ old('imperial', $unitQuantity->imperial) }}">
                @if($errors->has('imperial'))
                    <div class="invalid-feedback">
                        {{ $errors->first('imperial') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.unitQuantity.fields.imperial_helper') }}</span>
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