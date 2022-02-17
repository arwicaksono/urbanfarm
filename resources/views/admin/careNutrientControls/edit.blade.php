@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.careNutrientControl.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.care-nutrient-controls.update", [$careNutrientControl->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.careNutrientControl.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $careNutrientControl->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.careNutrientControl.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $careNutrientControl->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.careNutrientControl.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $careNutrientControl->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_start">{{ trans('cruds.careNutrientControl.fields.time_start') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_start') ? 'is-invalid' : '' }}" type="text" name="time_start" id="time_start" value="{{ old('time_start', $careNutrientControl->time_start) }}">
                @if($errors->has('time_start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.time_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_end">{{ trans('cruds.careNutrientControl.fields.time_end') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_end') ? 'is-invalid' : '' }}" type="text" name="time_end" id="time_end" value="{{ old('time_end', $careNutrientControl->time_end) }}">
                @if($errors->has('time_end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.time_end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="problem_nc_id">{{ trans('cruds.careNutrientControl.fields.problem_nc') }}</label>
                <select class="form-control select2 {{ $errors->has('problem_nc') ? 'is-invalid' : '' }}" name="problem_nc_id" id="problem_nc_id">
                    @foreach($problem_ncs as $id => $entry)
                        <option value="{{ $id }}" {{ (old('problem_nc_id') ? old('problem_nc_id') : $careNutrientControl->problem_nc->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('problem_nc'))
                    <div class="invalid-feedback">
                        {{ $errors->first('problem_nc') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.problem_nc_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action">{{ trans('cruds.careNutrientControl.fields.action') }}</label>
                <input class="form-control {{ $errors->has('action') ? 'is-invalid' : '' }}" type="text" name="action" id="action" value="{{ old('action', $careNutrientControl->action) }}">
                @if($errors->has('action'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="efficacy_id">{{ trans('cruds.careNutrientControl.fields.efficacy') }}</label>
                <select class="form-control select2 {{ $errors->has('efficacy') ? 'is-invalid' : '' }}" name="efficacy_id" id="efficacy_id">
                    @foreach($efficacies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('efficacy_id') ? old('efficacy_id') : $careNutrientControl->efficacy->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('efficacy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('efficacy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.efficacy_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.careNutrientControl.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $careNutrientControl->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.careNutrientControl.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $careNutrientControl->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.careNutrientControl.fields.is_done') }}</label>
                <select class="form-control {{ $errors->has('is_done') ? 'is-invalid' : '' }}" name="is_done" id="is_done">
                    <option value disabled {{ old('is_done', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CareNutrientControl::IS_DONE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_done', $careNutrientControl->is_done) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_done'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_done') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.is_done_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.careNutrientControl.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.careNutrientControl.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $careNutrientControl->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.careNutrientControl.fields.person_in_charge') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('person_in_charges') ? 'is-invalid' : '' }}" name="person_in_charges[]" id="person_in_charges" multiple>
                    @foreach($person_in_charges as $id => $person_in_charge)
                        <option value="{{ $id }}" {{ (in_array($id, old('person_in_charges', [])) || $careNutrientControl->person_in_charges->contains($id)) ? 'selected' : '' }}>{{ $person_in_charge }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careNutrientControl.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.care-nutrient-controls.storeMedia') }}',
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
@if(isset($careNutrientControl) && $careNutrientControl->image)
      var file = {!! json_encode($careNutrientControl->image) !!}
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