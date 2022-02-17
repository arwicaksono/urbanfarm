@extends('layouts.admin')
@section('content')
@can('sales_customer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sales-customers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.salesCustomer.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'SalesCustomer', 'route' => 'admin.sales-customers.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.salesCustomer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SalesCustomer">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.website') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesCustomer.fields.note') }}
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
@can('sales_customer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sales-customers.massDestroy') }}",
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
    ajax: "{{ route('admin.sales-customers.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'name', name: 'name' },
{ data: 'address', name: 'address' },
{ data: 'status_name', name: 'status.name' },
{ data: 'category', name: 'categories.name' },
{ data: 'tag', name: 'tags.name' },
{ data: 'phone', name: 'phone' },
{ data: 'email', name: 'email' },
{ data: 'website', name: 'website' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-SalesCustomer').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection