@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.businessSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.business-settings.update", [$businessSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.businessSetting.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $businessSetting->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="logo">{{ trans('cruds.businessSetting.fields.logo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="banner">{{ trans('cruds.businessSetting.fields.banner') }}</label>
                <div class="needsclick dropzone {{ $errors->has('banner') ? 'is-invalid' : '' }}" id="banner-dropzone">
                </div>
                @if($errors->has('banner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('banner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.banner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.businessSetting.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $businessSetting->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.businessSetting.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $businessSetting->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.businessSetting.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="number" name="phone" id="phone" value="{{ old('phone', $businessSetting->phone) }}" step="1">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsapp">{{ trans('cruds.businessSetting.fields.whatsapp') }}</label>
                <input class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" type="number" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $businessSetting->whatsapp) }}" step="1">
                @if($errors->has('whatsapp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.whatsapp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="telegram">{{ trans('cruds.businessSetting.fields.telegram') }}</label>
                <input class="form-control {{ $errors->has('telegram') ? 'is-invalid' : '' }}" type="number" name="telegram" id="telegram" value="{{ old('telegram', $businessSetting->telegram) }}" step="1">
                @if($errors->has('telegram'))
                    <div class="invalid-feedback">
                        {{ $errors->first('telegram') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.telegram_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facebook">{{ trans('cruds.businessSetting.fields.facebook') }}</label>
                <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" type="text" name="facebook" id="facebook" value="{{ old('facebook', $businessSetting->facebook) }}">
                @if($errors->has('facebook'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.facebook_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="twitter">{{ trans('cruds.businessSetting.fields.twitter') }}</label>
                <input class="form-control {{ $errors->has('twitter') ? 'is-invalid' : '' }}" type="text" name="twitter" id="twitter" value="{{ old('twitter', $businessSetting->twitter) }}">
                @if($errors->has('twitter'))
                    <div class="invalid-feedback">
                        {{ $errors->first('twitter') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.twitter_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="instagram">{{ trans('cruds.businessSetting.fields.instagram') }}</label>
                <input class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}" type="text" name="instagram" id="instagram" value="{{ old('instagram', $businessSetting->instagram) }}">
                @if($errors->has('instagram'))
                    <div class="invalid-feedback">
                        {{ $errors->first('instagram') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.instagram_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="linked_in">{{ trans('cruds.businessSetting.fields.linked_in') }}</label>
                <input class="form-control {{ $errors->has('linked_in') ? 'is-invalid' : '' }}" type="text" name="linked_in" id="linked_in" value="{{ old('linked_in', $businessSetting->linked_in) }}">
                @if($errors->has('linked_in'))
                    <div class="invalid-feedback">
                        {{ $errors->first('linked_in') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.linked_in_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="youtube">{{ trans('cruds.businessSetting.fields.youtube') }}</label>
                <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube" id="youtube" value="{{ old('youtube', $businessSetting->youtube) }}">
                @if($errors->has('youtube'))
                    <div class="invalid-feedback">
                        {{ $errors->first('youtube') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.youtube_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pinterest">{{ trans('cruds.businessSetting.fields.pinterest') }}</label>
                <input class="form-control {{ $errors->has('pinterest') ? 'is-invalid' : '' }}" type="text" name="pinterest" id="pinterest" value="{{ old('pinterest', $businessSetting->pinterest) }}">
                @if($errors->has('pinterest'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pinterest') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.pinterest_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reddit">{{ trans('cruds.businessSetting.fields.reddit') }}</label>
                <input class="form-control {{ $errors->has('reddit') ? 'is-invalid' : '' }}" type="text" name="reddit" id="reddit" value="{{ old('reddit', $businessSetting->reddit) }}">
                @if($errors->has('reddit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reddit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.reddit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="website">{{ trans('cruds.businessSetting.fields.website') }}</label>
                <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text" name="website" id="website" value="{{ old('website', $businessSetting->website) }}">
                @if($errors->has('website'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.businessSetting.fields.website_helper') }}</span>
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
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.business-settings.storeMedia') }}',
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
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($businessSetting) && $businessSetting->logo)
      var file = {!! json_encode($businessSetting->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.bannerDropzone = {
    url: '{{ route('admin.business-settings.storeMedia') }}',
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
      $('form').find('input[name="banner"]').remove()
      $('form').append('<input type="hidden" name="banner" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="banner"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($businessSetting) && $businessSetting->banner)
      var file = {!! json_encode($businessSetting->banner) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="banner" value="' + file.file_name + '">')
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