@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.plotVariety.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.plot-varieties.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.plotVariety.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotVariety.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="brand_id">{{ trans('cruds.plotVariety.fields.brand') }}</label>
                <select class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}" name="brand_id" id="brand_id">
                    @foreach($brands as $id => $entry)
                        <option value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('brand'))
                    <div class="invalid-feedback">
                        {{ $errors->first('brand') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotVariety.fields.brand_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.plotVariety.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotVariety.fields.note_helper') }}</span>
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