@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.carePreOrder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.care-pre-orders.update", [$carePreOrder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.carePreOrder.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $carePreOrder->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.carePreOrder.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $carePreOrder->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.carePreOrder.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $carePreOrder->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.carePreOrder.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $carePreOrder->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="customer_id">{{ trans('cruds.carePreOrder.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id">
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $carePreOrder->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="product_id">{{ trans('cruds.carePreOrder.fields.product') }}</label>
                <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id">
                    @foreach($products as $id => $entry)
                        <option value="{{ $id }}" {{ (old('product_id') ? old('product_id') : $carePreOrder->product->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="qty">{{ trans('cruds.carePreOrder.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" name="qty" id="qty" value="{{ old('qty', $carePreOrder->qty) }}" step="1">
                @if($errors->has('qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_id">{{ trans('cruds.carePreOrder.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id">
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $carePreOrder->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_due">{{ trans('cruds.carePreOrder.fields.date_due') }}</label>
                <input class="form-control date {{ $errors->has('date_due') ? 'is-invalid' : '' }}" type="text" name="date_due" id="date_due" value="{{ old('date_due', $carePreOrder->date_due) }}">
                @if($errors->has('date_due'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_due') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.date_due_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_due">{{ trans('cruds.carePreOrder.fields.time_due') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_due') ? 'is-invalid' : '' }}" type="text" name="time_due" id="time_due" value="{{ old('time_due', $carePreOrder->time_due) }}">
                @if($errors->has('time_due'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_due') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.time_due_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.carePreOrder.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $carePreOrder->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="priority_id">{{ trans('cruds.carePreOrder.fields.priority') }}</label>
                <select class="form-control select2 {{ $errors->has('priority') ? 'is-invalid' : '' }}" name="priority_id" id="priority_id">
                    @foreach($priorities as $id => $entry)
                        <option value="{{ $id }}" {{ (old('priority_id') ? old('priority_id') : $carePreOrder->priority->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('priority'))
                    <div class="invalid-feedback">
                        {{ $errors->first('priority') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.priority_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_delivery">{{ trans('cruds.carePreOrder.fields.date_delivery') }}</label>
                <input class="form-control date {{ $errors->has('date_delivery') ? 'is-invalid' : '' }}" type="text" name="date_delivery" id="date_delivery" value="{{ old('date_delivery', $carePreOrder->date_delivery) }}">
                @if($errors->has('date_delivery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_delivery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.date_delivery_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_delivery">{{ trans('cruds.carePreOrder.fields.time_delivery') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_delivery') ? 'is-invalid' : '' }}" type="text" name="time_delivery" id="time_delivery" value="{{ old('time_delivery', $carePreOrder->time_delivery) }}">
                @if($errors->has('time_delivery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_delivery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.time_delivery_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.carePreOrder.fields.payment') }}</label>
                <select class="form-control {{ $errors->has('payment') ? 'is-invalid' : '' }}" name="payment" id="payment">
                    <option value disabled {{ old('payment', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CarePreOrder::PAYMENT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('payment', $carePreOrder->payment) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.payment_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.carePreOrder.fields.is_done') }}</label>
                <select class="form-control {{ $errors->has('is_done') ? 'is-invalid' : '' }}" name="is_done" id="is_done">
                    <option value disabled {{ old('is_done', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CarePreOrder::IS_DONE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_done', $carePreOrder->is_done) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_done'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_done') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.is_done_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.carePreOrder.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.carePreOrder.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $carePreOrder->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="person_in_charges">{{ trans('cruds.carePreOrder.fields.person_in_charge') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('person_in_charges') ? 'is-invalid' : '' }}" name="person_in_charges[]" id="person_in_charges" multiple>
                    @foreach($person_in_charges as $id => $person_in_charge)
                        <option value="{{ $id }}" {{ (in_array($id, old('person_in_charges', [])) || $carePreOrder->person_in_charges->contains($id)) ? 'selected' : '' }}>{{ $person_in_charge }}</option>
                    @endforeach
                </select>
                @if($errors->has('person_in_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('person_in_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carePreOrder.fields.person_in_charge_helper') }}</span>
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
    url: '{{ route('admin.care-pre-orders.storeMedia') }}',
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
@if(isset($carePreOrder) && $carePreOrder->image)
      var files = {!! json_encode($carePreOrder->image) !!}
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