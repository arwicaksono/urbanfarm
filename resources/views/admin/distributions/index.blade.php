@extends('layouts.admin')
@section('content')
@can('distribution_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.distributions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.distribution.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Distribution', 'route' => 'admin.distributions.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.distribution.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Distribution">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.packing_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.customer') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.channel') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.market') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.delivery') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.cost') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.distribution.fields.person_in_charge') }}
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
@can('distribution_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.distributions.massDestroy') }}",
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
    ajax: "{{ route('admin.distributions.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'packing_code', name: 'packing_codes.code' },
{ data: 'customer_code', name: 'customer.code' },
{ data: 'channel_name', name: 'channel.name' },
{ data: 'market_name', name: 'market.name' },
{ data: 'delivery_name', name: 'delivery.name' },
{ data: 'cost', name: 'cost' },
{ data: 'status_name', name: 'status.name' },
{ data: 'tag', name: 'tags.name' },
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
  let table = $('.datatable-Distribution').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection