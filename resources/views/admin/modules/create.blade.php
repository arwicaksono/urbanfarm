@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.module.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.modules.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.module.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.module.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="site_code_id">{{ trans('cruds.module.fields.site_code') }}</label>
                <select class="form-control select2 {{ $errors->has('site_code') ? 'is-invalid' : '' }}" name="site_code_id" id="site_code_id">
                    @foreach($site_codes as $id => $entry)
                        <option value="{{ $id }}" {{ old('site_code_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('site_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.site_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="system_id">{{ trans('cruds.module.fields.system') }}</label>
                <select class="form-control select2 {{ $errors->has('system') ? 'is-invalid' : '' }}" name="system_id" id="system_id">
                    @foreach($systems as $id => $entry)
                        <option value="{{ $id }}" {{ old('system_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('system'))
                    <div class="invalid-feedback">
                        {{ $errors->first('system') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.system_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lighting_id">{{ trans('cruds.module.fields.lighting') }}</label>
                <select class="form-control select2 {{ $errors->has('lighting') ? 'is-invalid' : '' }}" name="lighting_id" id="lighting_id">
                    @foreach($lightings as $id => $entry)
                        <option value="{{ $id }}" {{ old('lighting_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('lighting'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lighting') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.lighting_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reservoir_id">{{ trans('cruds.module.fields.reservoir') }}</label>
                <select class="form-control select2 {{ $errors->has('reservoir') ? 'is-invalid' : '' }}" name="reservoir_id" id="reservoir_id">
                    @foreach($reservoirs as $id => $entry)
                        <option value="{{ $id }}" {{ old('reservoir_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('reservoir'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reservoir') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.reservoir_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pump_id">{{ trans('cruds.module.fields.pump') }}</label>
                <select class="form-control select2 {{ $errors->has('pump') ? 'is-invalid' : '' }}" name="pump_id" id="pump_id">
                    @foreach($pumps as $id => $entry)
                        <option value="{{ $id }}" {{ old('pump_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('pump'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pump') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.pump_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mounting_id">{{ trans('cruds.module.fields.mounting') }}</label>
                <select class="form-control select2 {{ $errors->has('mounting') ? 'is-invalid' : '' }}" name="mounting_id" id="mounting_id">
                    @foreach($mountings as $id => $entry)
                        <option value="{{ $id }}" {{ old('mounting_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('mounting'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mounting') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.mounting_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="capacity">{{ trans('cruds.module.fields.capacity') }}</label>
                <input class="form-control {{ $errors->has('capacity') ? 'is-invalid' : '' }}" type="number" name="capacity" id="capacity" value="{{ old('capacity', '') }}" step="1">
                @if($errors->has('capacity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('capacity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.capacity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.module.fields.unit') }}</label>
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
                <span class="help-block">{{ trans('cruds.module.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="acitivities">{{ trans('cruds.module.fields.acitivity') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('acitivities') ? 'is-invalid' : '' }}" name="acitivities[]" id="acitivities" multiple>
                    @foreach($acitivities as $id => $acitivity)
                        <option value="{{ $id }}" {{ in_array($id, old('acitivities', [])) ? 'selected' : '' }}>{{ $acitivity }}</option>
                    @endforeach
                </select>
                @if($errors->has('acitivities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('acitivities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.acitivity_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.module.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Module::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', 'no') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.module.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.module.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.module.fields.note_helper') }}</span>
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
    url: '{{ route('admin.modules.storeMedia') }}',
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
@if(isset($module) && $module->image)
      var files = {!! json_encode($module->image) !!}
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