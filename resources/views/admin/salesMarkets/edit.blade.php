@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.salesMarket.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sales-markets.update", [$salesMarket->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.salesMarket.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $salesMarket->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.salesMarket.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" name="number" id="number" value="{{ old('number', $salesMarket->number) }}" step="1">
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.salesMarket.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $salesMarket->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="channel_id">{{ trans('cruds.salesMarket.fields.channel') }}</label>
                <select class="form-control select2 {{ $errors->has('channel') ? 'is-invalid' : '' }}" name="channel_id" id="channel_id">
                    @foreach($channels as $id => $entry)
                        <option value="{{ $id }}" {{ (old('channel_id') ? old('channel_id') : $salesMarket->channel->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('channel'))
                    <div class="invalid-feedback">
                        {{ $errors->first('channel') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.channel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_id">{{ trans('cruds.salesMarket.fields.payment') }}</label>
                <select class="form-control select2 {{ $errors->has('payment') ? 'is-invalid' : '' }}" name="payment_id" id="payment_id">
                    @foreach($payments as $id => $entry)
                        <option value="{{ $id }}" {{ (old('payment_id') ? old('payment_id') : $salesMarket->payment->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.payment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.salesMarket.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $salesMarket->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="website">{{ trans('cruds.salesMarket.fields.website') }}</label>
                <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', $salesMarket->website) }}">
                @if($errors->has('website'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.website_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.salesMarket.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $salesMarket->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.salesMarket.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $salesMarket->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.salesMarket.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $salesMarket->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.salesMarket.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.salesMarket.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $salesMarket->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.salesMarket.fields.note_helper') }}</span>
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
    url: '{{ route('admin.sales-markets.storeMedia') }}',
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
@if(isset($salesMarket) && $salesMarket->image)
      var files = {!! json_encode($salesMarket->image) !!}
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