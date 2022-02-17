@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.siteInspection.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.site-inspections.update", [$siteInspection->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.siteInspection.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $siteInspection->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.siteInspection.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $siteInspection->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.siteInspection.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $siteInspection->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.siteInspection.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $siteInspection->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="site_id">{{ trans('cruds.siteInspection.fields.site') }}</label>
                <select class="form-control select2 {{ $errors->has('site') ? 'is-invalid' : '' }}" name="site_id" id="site_id">
                    @foreach($sites as $id => $entry)
                        <option value="{{ $id }}" {{ (old('site_id') ? old('site_id') : $siteInspection->site->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('site'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="temperature">{{ trans('cruds.siteInspection.fields.temperature') }}</label>
                <input class="form-control {{ $errors->has('temperature') ? 'is-invalid' : '' }}" type="number" name="temperature" id="temperature" value="{{ old('temperature', $siteInspection->temperature) }}" step="0.01">
                @if($errors->has('temperature'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temperature') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.temperature_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="humidity">{{ trans('cruds.siteInspection.fields.humidity') }}</label>
                <input class="form-control {{ $errors->has('humidity') ? 'is-invalid' : '' }}" type="number" name="humidity" id="humidity" value="{{ old('humidity', $siteInspection->humidity) }}" step="1">
                @if($errors->has('humidity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('humidity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.humidity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="weather_id">{{ trans('cruds.siteInspection.fields.weather') }}</label>
                <select class="form-control select2 {{ $errors->has('weather') ? 'is-invalid' : '' }}" name="weather_id" id="weather_id">
                    @foreach($weather as $id => $entry)
                        <option value="{{ $id }}" {{ (old('weather_id') ? old('weather_id') : $siteInspection->weather->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('weather'))
                    <div class="invalid-feedback">
                        {{ $errors->first('weather') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.weather_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.siteInspection.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $siteInspection->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.siteInspection.fields.is_problem') }}</label>
                <select class="form-control {{ $errors->has('is_problem') ? 'is-invalid' : '' }}" name="is_problem" id="is_problem">
                    <option value disabled {{ old('is_problem', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SiteInspection::IS_PROBLEM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_problem', $siteInspection->is_problem) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_problem'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_problem') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.is_problem_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="priority_id">{{ trans('cruds.siteInspection.fields.priority') }}</label>
                <select class="form-control select2 {{ $errors->has('priority') ? 'is-invalid' : '' }}" name="priority_id" id="priority_id">
                    @foreach($priorities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('priority_id') ? old('priority_id') : $siteInspection->priority->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('priority'))
                    <div class="invalid-feedback">
                        {{ $errors->first('priority') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.siteInspection.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.siteInspection.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $siteInspection->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charge_id">{{ trans('cruds.siteInspection.fields.person_in_charge') }}</label>
                <select class="form-control select2 {{ $errors->has('person_in_charge') ? 'is-invalid' : '' }}" name="person_in_charge_id" id="person_in_charge_id">
                    @foreach($person_in_charges as $id => $entry)
                        <option value="{{ $id }}" {{ (old('person_in_charge_id') ? old('person_in_charge_id') : $siteInspection->person_in_charge->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charge') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.siteInspection.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.site-inspections.storeMedia') }}',
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
@if(isset($siteInspection) && $siteInspection->image)
      var files = {!! json_encode($siteInspection->image) !!}
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