@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.adminInfo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.admin-infos.update", [$adminInfo->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="code">{{ trans('cruds.adminInfo.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $adminInfo->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start">{{ trans('cruds.adminInfo.fields.start') }}</label>
                <input class="form-control date {{ $errors->has('start') ? 'is-invalid' : '' }}" type="text" name="start" id="start" value="{{ old('start', $adminInfo->start) }}">
                @if($errors->has('start'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end">{{ trans('cruds.adminInfo.fields.end') }}</label>
                <input class="form-control date {{ $errors->has('end') ? 'is-invalid' : '' }}" type="text" name="end" id="end" value="{{ old('end', $adminInfo->end) }}">
                @if($errors->has('end'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.end_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.adminInfo.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $adminInfo->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.adminInfo.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $adminInfo->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other">{{ trans('cruds.adminInfo.fields.other') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('other') ? 'is-invalid' : '' }}" name="other" id="other">{!! old('other', $adminInfo->other) !!}</textarea>
                @if($errors->has('other'))
                    <div class="invalid-feedback">
                        {{ $errors->first('other') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.other_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.adminInfo.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.adminInfo.fields.note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{!! old('note', $adminInfo->note) !!}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminInfo.fields.note_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.admin-infos.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $adminInfo->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.admin-infos.storeMedia') }}',
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
@if(isset($adminInfo) && $adminInfo->image)
      var file = {!! json_encode($adminInfo->image) !!}
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