@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.adminDatabase.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.admin-databases.update", [$adminDatabase->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="image">{{ trans('cruds.adminDatabase.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.adminDatabase.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $adminDatabase->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="subtitle">{{ trans('cruds.adminDatabase.fields.subtitle') }}</label>
                <input class="form-control {{ $errors->has('subtitle') ? 'is-invalid' : '' }}" type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $adminDatabase->subtitle) }}">
                @if($errors->has('subtitle'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subtitle') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.subtitle_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.adminDatabase.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $adminDatabase->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cause">{{ trans('cruds.adminDatabase.fields.cause') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('cause') ? 'is-invalid' : '' }}" name="cause" id="cause">{!! old('cause', $adminDatabase->cause) !!}</textarea>
                @if($errors->has('cause'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cause') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.cause_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="prevention">{{ trans('cruds.adminDatabase.fields.prevention') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('prevention') ? 'is-invalid' : '' }}" name="prevention" id="prevention">{!! old('prevention', $adminDatabase->prevention) !!}</textarea>
                @if($errors->has('prevention'))
                    <div class="invalid-feedback">
                        {{ $errors->first('prevention') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.prevention_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="treatment">{{ trans('cruds.adminDatabase.fields.treatment') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('treatment') ? 'is-invalid' : '' }}" name="treatment" id="treatment">{!! old('treatment', $adminDatabase->treatment) !!}</textarea>
                @if($errors->has('treatment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('treatment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.treatment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="recommendation">{{ trans('cruds.adminDatabase.fields.recommendation') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('recommendation') ? 'is-invalid' : '' }}" name="recommendation" id="recommendation">{!! old('recommendation', $adminDatabase->recommendation) !!}</textarea>
                @if($errors->has('recommendation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('recommendation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.recommendation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.adminDatabase.fields.tag') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $adminDatabase->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="source">{{ trans('cruds.adminDatabase.fields.source') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('source') ? 'is-invalid' : '' }}" name="source" id="source">{!! old('source', $adminDatabase->source) !!}</textarea>
                @if($errors->has('source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.adminDatabase.fields.source_helper') }}</span>
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
    url: '{{ route('admin.admin-databases.storeMedia') }}',
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
@if(isset($adminDatabase) && $adminDatabase->image)
      var files = {!! json_encode($adminDatabase->image) !!}
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
                xhr.open('POST', '{{ route('admin.admin-databases.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $adminDatabase->id ?? 0 }}');
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

@endsection