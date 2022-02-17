@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.harvest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.harvests.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.harvest.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.harvest.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.harvest.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.harvest.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time') }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plot_id">{{ trans('cruds.harvest.fields.plot') }}</label>
                <select class="form-control select2 {{ $errors->has('plot') ? 'is-invalid' : '' }}" name="plot_id" id="plot_id">
                    @foreach($plots as $id => $entry)
                        <option value="{{ $id }}" {{ old('plot_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('plot'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plot') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.plot_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age">{{ trans('cruds.harvest.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', '') }}" step="1">
                @if($errors->has('age'))
                    <div class="invalid-feedback">
                        {{ $errors->first('age') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.harvest.fields.unit') }}</label>
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
                <span class="help-block">{{ trans('cruds.harvest.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="round">{{ trans('cruds.harvest.fields.round') }}</label>
                <input class="form-control {{ $errors->has('round') ? 'is-invalid' : '' }}" type="number" name="round" id="round" value="{{ old('round', '') }}" step="1">
                @if($errors->has('round'))
                    <div class="invalid-feedback">
                        {{ $errors->first('round') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.round_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grades">{{ trans('cruds.harvest.fields.grade') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('grades') ? 'is-invalid' : '' }}" name="grades[]" id="grades" multiple>
                    @foreach($grades as $id => $grade)
                        <option value="{{ $id }}" {{ in_array($id, old('grades', [])) ? 'selected' : '' }}>{{ $grade }}</option>
                    @endforeach
                </select>
                @if($errors->has('grades'))
                    <div class="invalid-feedback">
                        {{ $errors->first('grades') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.grade_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="harvest_qty">{{ trans('cruds.harvest.fields.harvest_qty') }}</label>
                <input class="form-control {{ $errors->has('harvest_qty') ? 'is-invalid' : '' }}" type="number" name="harvest_qty" id="harvest_qty" value="{{ old('harvest_qty', '') }}" step="1">
                @if($errors->has('harvest_qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('harvest_qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.harvest_qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="harvest_unit_id">{{ trans('cruds.harvest.fields.harvest_unit') }}</label>
                <select class="form-control select2 {{ $errors->has('harvest_unit') ? 'is-invalid' : '' }}" name="harvest_unit_id" id="harvest_unit_id">
                    @foreach($harvest_units as $id => $entry)
                        <option value="{{ $id }}" {{ old('harvest_unit_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('harvest_unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('harvest_unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.harvest_unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.harvest.fields.status') }}</label>
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
                <span class="help-block">{{ trans('cruds.harvest.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.harvest.fields.tag') }}</label>
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
                <span class="help-block">{{ trans('cruds.harvest.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.harvest.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Harvest::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', 'yes') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.harvest.fields.is_problem') }}</label>
                <select class="form-control {{ $errors->has('is_problem') ? 'is-invalid' : '' }}" name="is_problem" id="is_problem">
                    <option value disabled {{ old('is_problem', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Harvest::IS_PROBLEM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_problem', 'no') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_problem'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_problem') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.is_problem_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="priority_id">{{ trans('cruds.harvest.fields.priority') }}</label>
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
                <span class="help-block">{{ trans('cruds.harvest.fields.priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.harvest.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.harvest.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.harvest.fields.person_in_charge') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('person_in_charges') ? 'is-invalid' : '' }}" name="person_in_charges[]" id="person_in_charges" multiple>
                    @foreach($person_in_charges as $id => $person_in_charge)
                        <option value="{{ $id }}" {{ in_array($id, old('person_in_charges', [])) ? 'selected' : '' }}>{{ $person_in_charge }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.harvest.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.harvests.storeMedia') }}',
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
@if(isset($harvest) && $harvest->image)
      var files = {!! json_encode($harvest->image) !!}
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