@extends('layouts.admin')
@section('content')
@can('site_inspection_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.site-inspections.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.siteInspection.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'SiteInspection', 'route' => 'admin.site-inspections.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.siteInspection.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SiteInspection">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.site') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.temperature') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.humidity') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.weather') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.siteInspection.fields.person_in_charge') }}
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
@can('site_inspection_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.site-inspections.massDestroy') }}",
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
    ajax: "{{ route('admin.site-inspections.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'site_code', name: 'site.code' },
{ data: 'temperature', name: 'temperature' },
{ data: 'humidity', name: 'humidity' },
{ data: 'weather_name', name: 'weather.name' },
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
  let table = $('.datatable-SiteInspection').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection