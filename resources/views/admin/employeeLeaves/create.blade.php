@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeLeave.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-leaves.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name_id">{{ trans('cruds.employeeLeave.fields.name') }}</label>
                <select class="form-control select2 {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name_id" id="name_id">
                    @foreach($names as $id => $entry)
                        <option value="{{ $id }}" {{ old('name_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeLeave.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="leave_type_id">{{ trans('cruds.employeeLeave.fields.leave_type') }}</label>
                <select class="form-control select2 {{ $errors->has('leave_type') ? 'is-invalid' : '' }}" name="leave_type_id" id="leave_type_id">
                    @foreach($leave_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('leave_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('leave_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeLeave.fields.leave_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_start">{{ trans('cruds.employeeLeave.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start') }}">
                @if($errors->has('date_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeLeave.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_end">{{ trans('cruds.employeeLeave.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end') }}">
                @if($errors->has('date_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeLeave.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.employeeLeave.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeLeave.fields.note_helper') }}</span>
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