@extends('layouts.admin')
@section('content')
@can('business_setting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.business-settings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.businessSetting.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'BusinessSetting', 'route' => 'admin.business-settings.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.businessSetting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-BusinessSetting">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.logo') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.banner') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.whatsapp') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.telegram') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.facebook') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.twitter') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.instagram') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.linked_in') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.youtube') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.pinterest') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.reddit') }}
                    </th>
                    <th>
                        {{ trans('cruds.businessSetting.fields.website') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('business_setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.business-settings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.business-settings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'logo', name: 'logo', sortable: false, searchable: false },
{ data: 'banner', name: 'banner', sortable: false, searchable: false },
{ data: 'address', name: 'address' },
{ data: 'email', name: 'email' },
{ data: 'phone', name: 'phone' },
{ data: 'whatsapp', name: 'whatsapp' },
{ data: 'telegram', name: 'telegram' },
{ data: 'facebook', name: 'facebook' },
{ data: 'twitter', name: 'twitter' },
{ data: 'instagram', name: 'instagram' },
{ data: 'linked_in', name: 'linked_in' },
{ data: 'youtube', name: 'youtube' },
{ data: 'pinterest', name: 'pinterest' },
{ data: 'reddit', name: 'reddit' },
{ data: 'website', name: 'website' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-BusinessSetting').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection