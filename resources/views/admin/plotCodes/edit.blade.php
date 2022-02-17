@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.plotCode.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.plot-codes.update", [$plotCode->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="prefix">{{ trans('cruds.plotCode.fields.prefix') }}</label>
                <input class="form-control {{ $errors->has('prefix') ? 'is-invalid' : '' }}" type="text" name="prefix" id="prefix" value="{{ old('prefix', $plotCode->prefix) }}">
                @if($errors->has('prefix'))
                    <div class="invalid-feedback">
                        {{ $errors->first('prefix') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotCode.fields.prefix_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plant">{{ trans('cruds.plotCode.fields.plant') }}</label>
                <input class="form-control {{ $errors->has('plant') ? 'is-invalid' : '' }}" type="text" name="plant" id="plant" value="{{ old('plant', $plotCode->plant) }}">
                @if($errors->has('plant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotCode.fields.plant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.plotCode.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $plotCode->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotCode.fields.note_helper') }}</span>
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