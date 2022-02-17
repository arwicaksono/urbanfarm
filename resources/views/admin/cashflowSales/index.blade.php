@extends('layouts.admin')
@section('content')
@can('cashflow_sale_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.cashflow-sales.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.cashflowSale.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CashflowSale', 'route' => 'admin.cashflow-sales.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.cashflowSale.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CashflowSale">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.packing_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.sales_qty') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.unit') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.unit_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.discount') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.total_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.is_income') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.is_active') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.is_problem') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.is_priority') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.cashflowSale.fields.person_in_charge') }}
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
@can('cashflow_sale_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.cashflow-sales.massDestroy') }}",
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
    ajax: "{{ route('admin.cashflow-sales.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time', name: 'time' },
{ data: 'packing_code_code', name: 'packing_code.code' },
{ data: 'sales_qty', name: 'sales_qty' },
{ data: 'unit_name', name: 'unit.name' },
{ data: 'unit_price', name: 'unit_price' },
{ data: 'discount', name: 'discount' },
{ data: 'total_price', name: 'total_price' },
{ data: 'tag', name: 'tags.name' },
{ data: 'is_income', name: 'is_income' },
{ data: 'is_active', name: 'is_active' },
{ data: 'is_problem', name: 'is_problem' },
{ data: 'is_priority_name', name: 'is_priority.name' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'person_in_charge', name: 'person_in_charges.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-CashflowSale').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection