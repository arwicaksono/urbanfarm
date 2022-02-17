@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-attendances.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name_id">{{ trans('cruds.employeeAttendance.fields.name') }}</label>
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
                <span class="help-block">{{ trans('cruds.employeeAttendance.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.employeeAttendance.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeAttendance.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="arrival">{{ trans('cruds.employeeAttendance.fields.arrival') }}</label>
                <input class="form-control timepicker {{ $errors->has('arrival') ? 'is-invalid' : '' }}" type="text" name="arrival" id="arrival" value="{{ old('arrival') }}">
                @if($errors->has('arrival'))
                    <div class="invalid-feedback">
                        {{ $errors->first('arrival') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeAttendance.fields.arrival_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="departure">{{ trans('cruds.employeeAttendance.fields.departure') }}</label>
                <input class="form-control timepicker {{ $errors->has('departure') ? 'is-invalid' : '' }}" type="text" name="departure" id="departure" value="{{ old('departure') }}">
                @if($errors->has('departure'))
                    <div class="invalid-feedback">
                        {{ $errors->first('departure') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeAttendance.fields.departure_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.employeeAttendance.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeAttendance.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.employeeAttendance.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeAttendance.fields.note_helper') }}</span>
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
    var uploadedImageMap = {}
Dropzone.options.imageDropzone = {
    url: '{{ route('admin.employee-attendances.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
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
      $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
      uploadedImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImageMap[file.name]
      }
      $('form').find('input[name="image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($employeeAttendance) && $employeeAttendance->image)
      var files = {!! json_encode($employeeAttendance->image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="image[]" value="' + file.file_name + '">')
        }
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