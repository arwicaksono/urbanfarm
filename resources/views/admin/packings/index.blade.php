@extends('layouts.admin')
@section('content')
@can('packing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.packings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.packing.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Packing', 'route' => 'admin.packings.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.packing.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Packing">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.harvest_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.packing.fields.person_in_charge') }}
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
@can('packing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.packings.massDestroy') }}",
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
    ajax: "{{ route('admin.packings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'harvest_code', name: 'harvest_codes.code' },
{ data: 'status_name', name: 'status.name' },
{ data: 'tag', name: 'tags.name' },
{ data: 'is_active', name: 'is_active' },
{ data: 'is_problem', name: 'is_problem' },
{ data: 'priority_name', name: 'priority.name' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'person_in_charge_name', name: 'person_in_charge.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Packing').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection