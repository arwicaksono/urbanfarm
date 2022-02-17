@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.purchaseEquipment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.purchase-equipments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.purchaseEquipment.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.purchaseEquipment.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', '') }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.purchaseEquipment.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="quantity">{{ trans('cruds.purchaseEquipment.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="1">
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_price">{{ trans('cruds.purchaseEquipment.fields.unit_price') }}</label>
                <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" step="1">
                @if($errors->has('unit_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.unit_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="source_id">{{ trans('cruds.purchaseEquipment.fields.source') }}</label>
                <select class="form-control select2 {{ $errors->has('source') ? 'is-invalid' : '' }}" name="source_id" id="source_id">
                    @foreach($sources as $id => $entry)
                        <option value="{{ $id }}" {{ old('source_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.source_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.purchaseEquipment.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.purchaseEquipment.fields.tag') }}</label>
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
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="statuses">{{ trans('cruds.purchaseEquipment.fields.status') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('statuses') ? 'is-invalid' : '' }}" name="statuses[]" id="statuses" multiple>
                    @foreach($statuses as $id => $status)
                        <option value="{{ $id }}" {{ in_array($id, old('statuses', [])) ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('statuses'))
                    <div class="invalid-feedback">
                        {{ $errors->first('statuses') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.purchaseEquipment.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.purchaseEquipment.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseEquipment.fields.note_helper') }}</span>
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
    url: '{{ route('admin.purchase-equipments.storeMedia') }}',
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
@if(isset($purchaseEquipment) && $purchaseEquipment->image)
      var files = {!! json_encode($purchaseEquipment->image) !!}
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