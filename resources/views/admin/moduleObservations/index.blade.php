@extends('layouts.admin')
@section('content')
@can('module_observation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.module-observations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.moduleObservation.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'ModuleObservation', 'route' => 'admin.module-observations.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.moduleObservation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ModuleObservation">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.module') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.component') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.moduleObservation.fields.person_in_charge') }}
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
@can('module_observation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.module-observations.massDestroy') }}",
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
    ajax: "{{ route('admin.module-observations.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'module_code', name: 'module.code' },
{ data: 'component', name: 'components.code' },
{ data: 'tag', name: 'tags.name' },
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
  let table = $('.datatable-ModuleObservation').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection