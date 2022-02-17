@extends('layouts.admin')
@section('content')
@can('harvest_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.harvests.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.harvest.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Harvest', 'route' => 'admin.harvests.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.harvest.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Harvest">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.plot') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.age') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.round') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.grade') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.harvest_qty') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.harvest_unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.harvest.fields.person_in_charge') }}
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
@can('harvest_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.harvests.massDestroy') }}",
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
    ajax: "{{ route('admin.harvests.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'plot_code', name: 'plot.code' },
{ data: 'age', name: 'age' },
{ data: 'unit_name', name: 'unit.name' },
{ data: 'round', name: 'round' },
{ data: 'grade', name: 'grades.name' },
{ data: 'harvest_qty', name: 'harvest_qty' },
{ data: 'harvest_unit_name', name: 'harvest_unit.name' },
{ data: 'status_name', name: 'status.name' },
{ data: 'tag', name: 'tags.name' },
{ data: 'is_active', name: 'is_active' },
{ data: 'is_problem', name: 'is_problem' },
{ data: 'priority_name', name: 'priority.name' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'person_in_charge', name: 'person_in_charges.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Harvest').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection