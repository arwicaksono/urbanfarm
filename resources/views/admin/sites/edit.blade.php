@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.site.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sites.update", [$site->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.site.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $site->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.site.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $site->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.site.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $site->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="location">{{ trans('cruds.site.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', $site->location) }}">
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="elevation">{{ trans('cruds.site.fields.elevation') }}</label>
                <input class="form-control {{ $errors->has('elevation') ? 'is-invalid' : '' }}" type="number" name="elevation" id="elevation" value="{{ old('elevation', $site->elevation) }}" step="1">
                @if($errors->has('elevation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('elevation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.elevation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="acreage">{{ trans('cruds.site.fields.acreage') }}</label>
                <input class="form-control {{ $errors->has('acreage') ? 'is-invalid' : '' }}" type="number" name="acreage" id="acreage" value="{{ old('acreage', $site->acreage) }}" step="1">
                @if($errors->has('acreage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('acreage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.acreage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.site.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id">
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $site->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="settings">{{ trans('cruds.site.fields.setting') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('settings') ? 'is-invalid' : '' }}" name="settings[]" id="settings" multiple>
                    @foreach($settings as $id => $setting)
                        <option value="{{ $id }}" {{ (in_array($id, old('settings', [])) || $site->settings->contains($id)) ? 'selected' : '' }}>{{ $setting }}</option>
                    @endforeach
                </select>
                @if($errors->has('settings'))
                    <div class="invalid-feedback">
                        {{ $errors->first('settings') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.setting_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="water_sources">{{ trans('cruds.site.fields.water_source') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('water_sources') ? 'is-invalid' : '' }}" name="water_sources[]" id="water_sources" multiple>
                    @foreach($water_sources as $id => $water_source)
                        <option value="{{ $id }}" {{ (in_array($id, old('water_sources', [])) || $site->water_sources->contains($id)) ? 'selected' : '' }}>{{ $water_source }}</option>
                    @endforeach
                </select>
                @if($errors->has('water_sources'))
                    <div class="invalid-feedback">
                        {{ $errors->first('water_sources') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.water_source_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.site.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Site::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', $site->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.site.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.site.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $site->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.site.fields.person_in_charge') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('person_in_charges') ? 'is-invalid' : '' }}" name="person_in_charges[]" id="person_in_charges" multiple>
                    @foreach($person_in_charges as $id => $person_in_charge)
                        <option value="{{ $id }}" {{ (in_array($id, old('person_in_charges', [])) || $site->person_in_charges->contains($id)) ? 'selected' : '' }}>{{ $person_in_charge }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.site.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.sites.storeMedia') }}',
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
@if(isset($site) && $site->image)
      var files = {!! json_encode($site->image) !!}
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