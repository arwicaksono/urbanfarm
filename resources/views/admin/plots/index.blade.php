@extends('layouts.admin')
@section('content')
@can('plot_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.plots.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.plot.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Plot', 'route' => 'admin.plots.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.plot.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Plot">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.plot_prefix') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.activity') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.module') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.nutrient_brand') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.plot_qty') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.variety') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.date_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.time_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.date_end') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.time_end') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.plot.fields.note') }}
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
@can('plot_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.plots.massDestroy') }}",
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
    ajax: "{{ route('admin.plots.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'plot_prefix_prefix', name: 'plot_prefix.prefix' },
{ data: 'activity_name', name: 'activity.name' },
{ data: 'module_code', name: 'module.code' },
{ data: 'nutrient_brand_name', name: 'nutrient_brand.name' },
{ data: 'plot_qty', name: 'plot_qty' },
{ data: 'unit_name', name: 'unit.name' },
{ data: 'variety_name', name: 'variety.name' },
{ data: 'date_start', name: 'date_start' },
{ data: 'time_start', name: 'time_start' },
{ data: 'date_end', name: 'date_end' },
{ data: 'time_end', name: 'time_end' },
{ data: 'tag', name: 'tags.name' },
{ data: 'is_active', name: 'is_active' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Plot').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection