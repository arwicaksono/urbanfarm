@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.plotStage.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.plot-stages.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.plotStage.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotStage.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="period">{{ trans('cruds.plotStage.fields.period') }}</label>
                <input class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" type="text" name="period" id="period" value="{{ old('period', '') }}">
                @if($errors->has('period'))
                    <div class="invalid-feedback">
                        {{ $errors->first('period') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plotStage.fields.period_helper') }}</span>
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