@extends('layouts.admin')
@section('content')
@can('care_pre_order_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.care-pre-orders.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carePreOrder.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CarePreOrder', 'route' => 'admin.care-pre-orders.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carePreOrder.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CarePreOrder">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.customer') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.product') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.qty') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.date_due') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.time_due') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.date_delivery') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.time_delivery') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.payment') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.is_done') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePreOrder.fields.person_in_charge') }}
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
@can('care_pre_order_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.care-pre-orders.massDestroy') }}",
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
    ajax: "{{ route('admin.care-pre-orders.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'customer_code', name: 'customer.code' },
{ data: 'product_name', name: 'product.name' },
{ data: 'qty', name: 'qty' },
{ data: 'unit_name', name: 'unit.name' },
{ data: 'date_due', name: 'date_due' },
{ data: 'time_due', name: 'time_due' },
{ data: 'tag', name: 'tags.name' },
{ data: 'priority_name', name: 'priority.name' },
{ data: 'date_delivery', name: 'date_delivery' },
{ data: 'time_delivery', name: 'time_delivery' },
{ data: 'payment', name: 'payment' },
{ data: 'is_done', name: 'is_done' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'person_in_charge', name: 'person_in_charges.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-CarePreOrder').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection