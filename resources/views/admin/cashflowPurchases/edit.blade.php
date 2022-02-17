@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.cashflowPurchase.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cashflow-purchases.update", [$cashflowPurchase->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.cashflowPurchase.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $cashflowPurchase->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.cashflowPurchase.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $cashflowPurchase->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.cashflowPurchase.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $cashflowPurchase->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.cashflowPurchase.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $cashflowPurchase->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.cashflowPurchase.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $cashflowPurchase->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="quantity">{{ trans('cruds.cashflowPurchase.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', $cashflowPurchase->quantity) }}" step="1">
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_price">{{ trans('cruds.cashflowPurchase.fields.unit_price') }}</label>
                <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', $cashflowPurchase->unit_price) }}" step="1">
                @if($errors->has('unit_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.unit_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount">{{ trans('cruds.cashflowPurchase.fields.discount') }}</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', $cashflowPurchase->discount) }}" step="0.01">
                @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.discount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_price">{{ trans('cruds.cashflowPurchase.fields.total_price') }}</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', $cashflowPurchase->total_price) }}" step="1">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.total_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.cashflowPurchase.fields.is_expense') }}</label>
                <select class="form-control {{ $errors->has('is_expense') ? 'is-invalid' : '' }}" name="is_expense" id="is_expense">
                    <option value disabled {{ old('is_expense', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CashflowPurchase::IS_EXPENSE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_expense', $cashflowPurchase->is_expense) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_expense'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_expense') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.is_expense_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.cashflowPurchase.fields.is_problem') }}</label>
                <select class="form-control {{ $errors->has('is_problem') ? 'is-invalid' : '' }}" name="is_problem" id="is_problem">
                    <option value disabled {{ old('is_problem', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CashflowPurchase::IS_PROBLEM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_problem', $cashflowPurchase->is_problem) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_problem'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_problem') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.is_problem_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="is_priority_id">{{ trans('cruds.cashflowPurchase.fields.is_priority') }}</label>
                <select class="form-control select2 {{ $errors->has('is_priority') ? 'is-invalid' : '' }}" name="is_priority_id" id="is_priority_id">
                    @foreach($is_priorities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('is_priority_id') ? old('is_priority_id') : $cashflowPurchase->is_priority->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_priority'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_priority') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.is_priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.cashflowPurchase.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $cashflowPurchase->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.cashflowPurchase.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $cashflowPurchase->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.cashflowPurchase.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.cashflowPurchase.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $cashflowPurchase->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.cashflowPurchase.fields.person_in_charge') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('person_in_charges') ? 'is-invalid' : '' }}" name="person_in_charges[]" id="person_in_charges" multiple>
                    @foreach($person_in_charges as $id => $person_in_charge)
                        <option value="{{ $id }}" {{ (in_array($id, old('person_in_charges', [])) || $cashflowPurchase->person_in_charges->contains($id)) ? 'selected' : '' }}>{{ $person_in_charge }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowPurchase.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.cashflow-purchases.storeMedia') }}',
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
@if(isset($cashflowPurchase) && $cashflowPurchase->image)
      var files = {!! json_encode($cashflowPurchase->image) !!}
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