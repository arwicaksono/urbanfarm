@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.salesChannel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sales-channels.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.salesChannel.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesChannel.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.salesChannel.fields.sales_type') }}</label>
                <select class="form-control {{ $errors->has('sales_type') ? 'is-invalid' : '' }}" name="sales_type" id="sales_type">
                    <option value disabled {{ old('sales_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SalesChannel::SALES_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('sales_type', 'offline') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('sales_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sales_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesChannel.fields.sales_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.salesChannel.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesChannel.fields.note_helper') }}</span>
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