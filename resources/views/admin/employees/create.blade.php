@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="employee_name_id">{{ trans('cruds.employee.fields.employee_name') }}</label>
                <select class="form-control select2 {{ $errors->has('employee_name') ? 'is-invalid' : '' }}" name="employee_name_id" id="employee_name_id">
                    @foreach($employee_names as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_name_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.employee_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="birthdate">{{ trans('cruds.employee.fields.birthdate') }}</label>
                <input class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="text" name="birthdate" id="birthdate" value="{{ old('birthdate') }}">
                @if($errors->has('birthdate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('birthdate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.birthdate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.employee.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.employee.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="number" name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}" step="1">
                @if($errors->has('phone_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="position_id">{{ trans('cruds.employee.fields.position') }}</label>
                <select class="form-control select2 {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position_id" id="position_id">
                    @foreach($positions as $id => $entry)
                        <option value="{{ $id }}" {{ old('position_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('position'))
                    <div class="invalid-feedback">
                        {{ $errors->first('position') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.position_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.employee.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_start">{{ trans('cruds.employee.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start') }}">
                @if($errors->has('date_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_end">{{ trans('cruds.employee.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end') }}">
                @if($errors->has('date_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.employee.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.employee.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.note_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.employees.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($employee) && $employee->image)
      var file = {!! json_encode($employee->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection