@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.purchaseCompany.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.purchase-companies.update", [$purchaseCompany->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.purchaseCompany.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $purchaseCompany->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.purchaseCompany.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $purchaseCompany->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.purchaseCompany.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $purchaseCompany->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.purchaseCompany.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $purchaseCompany->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="website">{{ trans('cruds.purchaseCompany.fields.website') }}</label>
                <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', $purchaseCompany->website) }}">
                @if($errors->has('website'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.website_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_person_id">{{ trans('cruds.purchaseCompany.fields.contact_person') }}</label>
                <select class="form-control select2 {{ $errors->has('contact_person') ? 'is-invalid' : '' }}" name="contact_person_id" id="contact_person_id">
                    @foreach($contact_people as $id => $entry)
                        <option value="{{ $id }}" {{ (old('contact_person_id') ? old('contact_person_id') : $purchaseCompany->contact_person->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('contact_person'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_person') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.contact_person_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.purchaseCompany.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.purchaseCompany.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    @foreach($categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $purchaseCompany->category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.purchaseCompany.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $purchaseCompany->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.purchaseCompany.fields.note_helper') }}</span>
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
    url: '{{ route('admin.purchase-companies.storeMedia') }}',
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
@if(isset($purchaseCompany) && $purchaseCompany->image)
      var files = {!! json_encode($purchaseCompany->image) !!}
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