@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeJobDesc.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-job-descs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="position_id">{{ trans('cruds.employeeJobDesc.fields.position') }}</label>
                <select class="form-control select2 {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position_id" id="position_id">
                    @foreach($positions as $id => $entry)
                        <option value="{{ $id }}" {{ old('position_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('position'))
                    <div class="invalid-feedback">
                        {{ $errors->first('position') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeJobDesc.fields.position_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="detail">{{ trans('cruds.employeeJobDesc.fields.detail') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('detail') ? 'is-invalid' : '' }}" name="detail" id="detail">{!! old('detail') !!}</textarea>
                @if($errors->has('detail'))
                    <div class="invalid-feedback">
                        {{ $errors->first('detail') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeJobDesc.fields.detail_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.employeeJobDesc.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeJobDesc.fields.note_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.employee-job-descs.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $employeeJobDesc->id ?? 0 }}');
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