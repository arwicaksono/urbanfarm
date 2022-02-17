@extends('layouts.admin')
@section('content')
@can('admin_database_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.admin-databases.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.adminDatabase.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.adminDatabase.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AdminDatabase">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.image') }}
                        </th>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.subtitle') }}
                        </th>
                        <th>
                            {{ trans('cruds.adminDatabase.fields.tag') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adminDatabases as $key => $adminDatabase)
                        <tr data-entry-id="{{ $adminDatabase->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $adminDatabase->id ?? '' }}
                            </td>
                            <td>
                                @foreach($adminDatabase->image as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $adminDatabase->title ?? '' }}
                            </td>
                            <td>
                                {{ $adminDatabase->subtitle ?? '' }}
                            </td>
                            <td>
                                @foreach($adminDatabase->tags as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('admin_database_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.admin-databases.show', $adminDatabase->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('admin_database_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.admin-databases.edit', $adminDatabase->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('admin_database_delete')
                                    <form action="{{ route('admin.admin-databases.destroy', $adminDatabase->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('admin_database_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.admin-databases.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-AdminDatabase:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection