@extends('layouts.admin')
@section('content')
@can('module_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.modules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.module.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Module', 'route' => 'admin.modules.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.module.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Module">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.module.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.site_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.system') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.lighting') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.reservoir') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.pump') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.mounting') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.capacity') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.acitivity') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.module.fields.note') }}
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
@can('module_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.modules.massDestroy') }}",
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
    ajax: "{{ route('admin.modules.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'site_code_code', name: 'site_code.code' },
{ data: 'system_name', name: 'system.name' },
{ data: 'lighting_code', name: 'lighting.code' },
{ data: 'reservoir_code', name: 'reservoir.code' },
{ data: 'pump_code', name: 'pump.code' },
{ data: 'mounting_code', name: 'mounting.code' },
{ data: 'capacity', name: 'capacity' },
{ data: 'unit_name', name: 'unit.name' },
{ data: 'acitivity', name: 'acitivities.name' },
{ data: 'is_active', name: 'is_active' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Module').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection