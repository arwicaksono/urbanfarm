@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.nutrientControl.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.nutrient-controls.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.nutrientControl.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.nutrientControl.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.nutrientControl.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.nutrientControl.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time') }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="module_id">{{ trans('cruds.nutrientControl.fields.module') }}</label>
                <select class="form-control select2 {{ $errors->has('module') ? 'is-invalid' : '' }}" name="module_id" id="module_id">
                    @foreach($modules as $id => $entry)
                        <option value="{{ $id }}" {{ old('module_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('module'))
                    <div class="invalid-feedback">
                        {{ $errors->first('module') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.module_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ppm">{{ trans('cruds.nutrientControl.fields.ppm') }}</label>
                <input class="form-control {{ $errors->has('ppm') ? 'is-invalid' : '' }}" type="number" name="ppm" id="ppm" value="{{ old('ppm', '') }}" step="1">
                @if($errors->has('ppm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ppm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.ppm_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ec">{{ trans('cruds.nutrientControl.fields.ec') }}</label>
                <input class="form-control {{ $errors->has('ec') ? 'is-invalid' : '' }}" type="number" name="ec" id="ec" value="{{ old('ec', '') }}" step="1">
                @if($errors->has('ec'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ec') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.ec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ph">{{ trans('cruds.nutrientControl.fields.ph') }}</label>
                <input class="form-control {{ $errors->has('ph') ? 'is-invalid' : '' }}" type="number" name="ph" id="ph" value="{{ old('ph', '') }}" step="1">
                @if($errors->has('ph'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ph') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.ph_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="temperature">{{ trans('cruds.nutrientControl.fields.temperature') }}</label>
                <input class="form-control {{ $errors->has('temperature') ? 'is-invalid' : '' }}" type="number" name="temperature" id="temperature" value="{{ old('temperature', '') }}" step="1">
                @if($errors->has('temperature'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temperature') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.temperature_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.nutrientControl.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.nutrientControl.fields.is_problem') }}</label>
                <select class="form-control {{ $errors->has('is_problem') ? 'is-invalid' : '' }}" name="is_problem" id="is_problem">
                    <option value disabled {{ old('is_problem', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\NutrientControl::IS_PROBLEM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_problem', 'no') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_problem'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_problem') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.is_problem_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="priority_id">{{ trans('cruds.nutrientControl.fields.priority') }}</label>
                <select class="form-control select2 {{ $errors->has('priority') ? 'is-invalid' : '' }}" name="priority_id" id="priority_id">
                    @foreach($priorities as $id => $entry)
                        <option value="{{ $id }}" {{ old('priority_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('priority'))
                    <div class="invalid-feedback">
                        {{ $errors->first('priority') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.nutrientControl.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.nutrientControl.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charge_id">{{ trans('cruds.nutrientControl.fields.person_in_charge') }}</label>
                <select class="form-control select2 {{ $errors->has('person_in_charge') ? 'is-invalid' : '' }}" name="person_in_charge_id" id="person_in_charge_id">
                    @foreach($person_in_charges as $id => $entry)
                        <option value="{{ $id }}" {{ old('person_in_charge_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charge') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.nutrientControl.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.nutrient-controls.storeMedia') }}',
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
@if(isset($nutrientControl) && $nutrientControl->image)
      var files = {!! json_encode($nutrientControl->image) !!}
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