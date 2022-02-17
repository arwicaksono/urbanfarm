@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.salesLabel.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sales-labels.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.salesLabel.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesLabel.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="quantity">{{ trans('cruds.salesLabel.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="1">
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesLabel.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.salesLabel.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="1">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesLabel.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.salesLabel.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id">
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ old('unit_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesLabel.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="companies">{{ trans('cruds.salesLabel.fields.company') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('companies') ? 'is-invalid' : '' }}" name="companies[]" id="companies" multiple>
                    @foreach($companies as $id => $company)
                        <option value="{{ $id }}" {{ in_array($id, old('companies', [])) ? 'selected' : '' }}>{{ $company }}</option>
                    @endforeach
                </select>
                @if($errors->has('companies'))
                    <div class="invalid-feedback">
                        {{ $errors->first('companies') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesLabel.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.salesLabel.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesLabel.fields.note_helper') }}</span>
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