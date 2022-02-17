@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.plot.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.plots.update", [$plot->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.plot.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $plot->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.plot.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $plot->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plot_prefix_id">{{ trans('cruds.plot.fields.plot_prefix') }}</label>
                <select class="form-control select2 {{ $errors->has('plot_prefix') ? 'is-invalid' : '' }}" name="plot_prefix_id" id="plot_prefix_id">
                    @foreach($plot_prefixes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('plot_prefix_id') ? old('plot_prefix_id') : $plot->plot_prefix->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('plot_prefix'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plot_prefix') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.plot_prefix_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="activity_id">{{ trans('cruds.plot.fields.activity') }}</label>
                <select class="form-control select2 {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity_id" id="activity_id">
                    @foreach($activities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('activity_id') ? old('activity_id') : $plot->activity->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('activity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('activity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.activity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="module_id">{{ trans('cruds.plot.fields.module') }}</label>
                <select class="form-control select2 {{ $errors->has('module') ? 'is-invalid' : '' }}" name="module_id" id="module_id">
                    @foreach($modules as $id => $entry)
                        <option value="{{ $id }}" {{ (old('module_id') ? old('module_id') : $plot->module->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('module'))
                    <div class="invalid-feedback">
                        {{ $errors->first('module') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.module_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nutrient_brand_id">{{ trans('cruds.plot.fields.nutrient_brand') }}</label>
                <select class="form-control select2 {{ $errors->has('nutrient_brand') ? 'is-invalid' : '' }}" name="nutrient_brand_id" id="nutrient_brand_id">
                    @foreach($nutrient_brands as $id => $entry)
                        <option value="{{ $id }}" {{ (old('nutrient_brand_id') ? old('nutrient_brand_id') : $plot->nutrient_brand->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('nutrient_brand'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nutrient_brand') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.nutrient_brand_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plot_qty">{{ trans('cruds.plot.fields.plot_qty') }}</label>
                <input class="form-control {{ $errors->has('plot_qty') ? 'is-invalid' : '' }}" type="number" name="plot_qty" id="plot_qty" value="{{ old('plot_qty', $plot->plot_qty) }}" step="1">
                @if($errors->has('plot_qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plot_qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.plot_qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.plot.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id">
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $plot->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="variety_id">{{ trans('cruds.plot.fields.variety') }}</label>
                <select class="form-control select2 {{ $errors->has('variety') ? 'is-invalid' : '' }}" name="variety_id" id="variety_id">
                    @foreach($varieties as $id => $entry)
                        <option value="{{ $id }}" {{ (old('variety_id') ? old('variety_id') : $plot->variety->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('variety'))
                    <div class="invalid-feedback">
                        {{ $errors->first('variety') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.variety_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_start">{{ trans('cruds.plot.fields.date_start') }}</label>
                <input class="form-control date {{ $errors->has('date_start') ? 'is-invalid' : '' }}" type="text" name="date_start" id="date_start" value="{{ old('date_start', $plot->date_start) }}">
                @if($errors->has('date_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.date_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_start">{{ trans('cruds.plot.fields.time_start') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_start') ? 'is-invalid' : '' }}" type="text" name="time_start" id="time_start" value="{{ old('time_start', $plot->time_start) }}">
                @if($errors->has('time_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.time_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_end">{{ trans('cruds.plot.fields.date_end') }}</label>
                <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text" name="date_end" id="date_end" value="{{ old('date_end', $plot->date_end) }}">
                @if($errors->has('date_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.date_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_end">{{ trans('cruds.plot.fields.time_end') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_end') ? 'is-invalid' : '' }}" type="text" name="time_end" id="time_end" value="{{ old('time_end', $plot->time_end) }}">
                @if($errors->has('time_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.time_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.plot.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $plot->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.plot.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Plot::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', $plot->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.plot.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.plot.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $plot->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.plot.fields.note_helper') }}</span>
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
    url: '{{ route('admin.plots.storeMedia') }}',
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
@if(isset($plot) && $plot->image)
      var files = {!! json_encode($plot->image) !!}
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