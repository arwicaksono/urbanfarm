@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.moduleObservation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.module-observations.update", [$moduleObservation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.moduleObservation.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $moduleObservation->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.moduleObservation.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $moduleObservation->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.moduleObservation.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $moduleObservation->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.moduleObservation.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $moduleObservation->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="module_id">{{ trans('cruds.moduleObservation.fields.module') }}</label>
                <select class="form-control select2 {{ $errors->has('module') ? 'is-invalid' : '' }}" name="module_id" id="module_id">
                    @foreach($modules as $id => $entry)
                        <option value="{{ $id }}" {{ (old('module_id') ? old('module_id') : $moduleObservation->module->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('module'))
                    <div class="invalid-feedback">
                        {{ $errors->first('module') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.module_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="components">{{ trans('cruds.moduleObservation.fields.component') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('components') ? 'is-invalid' : '' }}" name="components[]" id="components" multiple>
                    @foreach($components as $id => $component)
                        <option value="{{ $id }}" {{ (in_array($id, old('components', [])) || $moduleObservation->components->contains($id)) ? 'selected' : '' }}>{{ $component }}</option>
                    @endforeach
                </select>
                @if($errors->has('components'))
                    <div class="invalid-feedback">
                        {{ $errors->first('components') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.component_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.moduleObservation.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $moduleObservation->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.moduleObservation.fields.is_problem') }}</label>
                <select class="form-control {{ $errors->has('is_problem') ? 'is-invalid' : '' }}" name="is_problem" id="is_problem">
                    <option value disabled {{ old('is_problem', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ModuleObservation::IS_PROBLEM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_problem', $moduleObservation->is_problem) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_problem'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_problem') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.is_problem_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="priority_id">{{ trans('cruds.moduleObservation.fields.priority') }}</label>
                <select class="form-control select2 {{ $errors->has('priority') ? 'is-invalid' : '' }}" name="priority_id" id="priority_id">
                    @foreach($priorities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('priority_id') ? old('priority_id') : $moduleObservation->priority->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('priority'))
                    <div class="invalid-feedback">
                        {{ $errors->first('priority') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.moduleObservation.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.moduleObservation.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $moduleObservation->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charge_id">{{ trans('cruds.moduleObservation.fields.person_in_charge') }}</label>
                <select class="form-control select2 {{ $errors->has('person_in_charge') ? 'is-invalid' : '' }}" name="person_in_charge_id" id="person_in_charge_id">
                    @foreach($person_in_charges as $id => $entry)
                        <option value="{{ $id }}" {{ (old('person_in_charge_id') ? old('person_in_charge_id') : $moduleObservation->person_in_charge->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charge') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moduleObservation.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.module-observations.storeMedia') }}',
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
@if(isset($moduleObservation) && $moduleObservation->image)
      var files = {!! json_encode($moduleObservation->image) !!}
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