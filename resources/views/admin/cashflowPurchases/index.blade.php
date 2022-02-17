@extends('layouts.admin')
@section('content')
@can('cashflow_purchase_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.cashflow-purchases.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.cashflowPurchase.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CashflowPurchase', 'route' => 'admin.cashflow-purchases.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.cashflowPurchase.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CashflowPurchase">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.unit_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.discount') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.total_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.is_expense') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.is_priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowPurchase.fields.person_in_charge') }}
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
@can('cashflow_purchase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.cashflow-purchases.massDestroy') }}",
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
    ajax: "{{ route('admin.cashflow-purchases.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'name', name: 'name' },
{ data: 'quantity', name: 'quantity' },
{ data: 'unit_price', name: 'unit_price' },
{ data: 'discount', name: 'discount' },
{ data: 'total_price', name: 'total_price' },
{ data: 'is_expense', name: 'is_expense' },
{ data: 'is_problem', name: 'is_problem' },
{ data: 'is_priority_name', name: 'is_priority.name' },
{ data: 'status_name', name: 'status.name' },
{ data: 'tag', name: 'tags.name' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'person_in_charge', name: 'person_in_charges.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-CashflowPurchase').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection