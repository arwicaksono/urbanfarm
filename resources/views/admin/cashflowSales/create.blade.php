@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cashflowSale.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cashflow-sales.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.cashflowSale.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.cashflowSale.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.cashflowSale.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.cashflowSale.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time') }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="packing_code_id">{{ trans('cruds.cashflowSale.fields.packing_code') }}</label>
                <select class="form-control select2 {{ $errors->has('packing_code') ? 'is-invalid' : '' }}" name="packing_code_id" id="packing_code_id">
                    @foreach($packing_codes as $id => $entry)
                        <option value="{{ $id }}" {{ old('packing_code_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('packing_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('packing_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.packing_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sales_qty">{{ trans('cruds.cashflowSale.fields.sales_qty') }}</label>
                <input class="form-control {{ $errors->has('sales_qty') ? 'is-invalid' : '' }}" type="number" name="sales_qty" id="sales_qty" value="{{ old('sales_qty', '') }}" step="1">
                @if($errors->has('sales_qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sales_qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.sales_qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.cashflowSale.fields.unit') }}</label>
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
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_price">{{ trans('cruds.cashflowSale.fields.unit_price') }}</label>
                <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" step="1">
                @if($errors->has('unit_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.unit_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount">{{ trans('cruds.cashflowSale.fields.discount') }}</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" step="0.01">
                @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.discount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_price">{{ trans('cruds.cashflowSale.fields.total_price') }}</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', '') }}" step="1">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.total_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.cashflowSale.fields.tag') }}</label>
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
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.cashflowSale.fields.is_income') }}</label>
                <select class="form-control {{ $errors->has('is_income') ? 'is-invalid' : '' }}" name="is_income" id="is_income">
                    <option value disabled {{ old('is_income', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CashflowSale::IS_INCOME_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_income', 'yes') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_income'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_income') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.is_income_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.cashflowSale.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CashflowSale::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', 'yes') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.cashflowSale.fields.is_problem') }}</label>
                <select class="form-control {{ $errors->has('is_problem') ? 'is-invalid' : '' }}" name="is_problem" id="is_problem">
                    <option value disabled {{ old('is_problem', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CashflowSale::IS_PROBLEM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_problem', 'no') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_problem'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_problem') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.is_problem_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="is_priority_id">{{ trans('cruds.cashflowSale.fields.is_priority') }}</label>
                <select class="form-control select2 {{ $errors->has('is_priority') ? 'is-invalid' : '' }}" name="is_priority_id" id="is_priority_id">
                    @foreach($is_priorities as $id => $entry)
                        <option value="{{ $id }}" {{ old('is_priority_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_priority'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_priority') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.is_priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.cashflowSale.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.cashflowSale.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.cashflowSale.fields.person_in_charge') }}</label>
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
                <span class="help-block">{{ trans('cruds.cashflowSale.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.cashflow-sales.storeMedia') }}',
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
@if(isset($cashflowSale) && $cashflowSale->image)
      var files = {!! json_encode($cashflowSale->image) !!}
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