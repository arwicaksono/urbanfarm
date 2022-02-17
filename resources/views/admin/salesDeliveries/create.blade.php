@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.salesDelivery.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sales-deliveries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.salesDelivery.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesDelivery.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.salesDelivery.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesDelivery.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact">{{ trans('cruds.salesDelivery.fields.contact') }}</label>
                <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text" name="contact" id="contact" value="{{ old('contact', '') }}">
                @if($errors->has('contact'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesDelivery.fields.contact_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.salesDelivery.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="number" name="phone" id="phone" value="{{ old('phone', '') }}" step="1">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesDelivery.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.salesDelivery.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesDelivery.fields.note_helper') }}</span>
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