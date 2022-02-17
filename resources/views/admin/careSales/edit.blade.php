@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.careSale.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.care-sales.update", [$careSale->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.careSale.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $careSale->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.careSale.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $careSale->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.careSale.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $careSale->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_start">{{ trans('cruds.careSale.fields.time_start') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_start') ? 'is-invalid' : '' }}" type="text" name="time_start" id="time_start" value="{{ old('time_start', $careSale->time_start) }}">
                @if($errors->has('time_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.time_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_end">{{ trans('cruds.careSale.fields.time_end') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_end') ? 'is-invalid' : '' }}" type="text" name="time_end" id="time_end" value="{{ old('time_end', $careSale->time_end) }}">
                @if($errors->has('time_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.time_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="problem_sale_id">{{ trans('cruds.careSale.fields.problem_sale') }}</label>
                <select class="form-control select2 {{ $errors->has('problem_sale') ? 'is-invalid' : '' }}" name="problem_sale_id" id="problem_sale_id">
                    @foreach($problem_sales as $id => $entry)
                        <option value="{{ $id }}" {{ (old('problem_sale_id') ? old('problem_sale_id') : $careSale->problem_sale->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('problem_sale'))
                    <div class="invalid-feedback">
                        {{ $errors->first('problem_sale') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.problem_sale_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action">{{ trans('cruds.careSale.fields.action') }}</label>
                <textarea class="form-control {{ $errors->has('action') ? 'is-invalid' : '' }}" name="action" id="action">{{ old('action', $careSale->action) }}</textarea>
                @if($errors->has('action'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.careSale.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $careSale->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.careSale.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $careSale->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.careSale.fields.is_done') }}</label>
                <select class="form-control {{ $errors->has('is_done') ? 'is-invalid' : '' }}" name="is_done" id="is_done">
                    <option value disabled {{ old('is_done', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CareSale::IS_DONE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_done', $careSale->is_done) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_done'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_done') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.is_done_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.careSale.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.careSale.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $careSale->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.careSale.fields.person_in_charge') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('person_in_charges') ? 'is-invalid' : '' }}" name="person_in_charges[]" id="person_in_charges" multiple>
                    @foreach($person_in_charges as $id => $person_in_charge)
                        <option value="{{ $id }}" {{ (in_array($id, old('person_in_charges', [])) || $careSale->person_in_charges->contains($id)) ? 'selected' : '' }}>{{ $person_in_charge }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careSale.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.care-sales.storeMedia') }}',
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
@if(isset($careSale) && $careSale->image)
      var files = {!! json_encode($careSale->image) !!}
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