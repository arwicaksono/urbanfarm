@extends('layouts.admin')
@section('content')
@can('sales_market_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sales-markets.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.salesMarket.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'SalesMarket', 'route' => 'admin.sales-markets.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.salesMarket.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SalesMarket">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.channel') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.payment') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.website') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.salesMarket.fields.note') }}
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
@can('sales_market_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sales-markets.massDestroy') }}",
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
    ajax: "{{ route('admin.sales-markets.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'name', name: 'name' },
{ data: 'channel_name', name: 'channel.name' },
{ data: 'payment_name', name: 'payment.name' },
{ data: 'address', name: 'address' },
{ data: 'website', name: 'website' },
{ data: 'email', name: 'email' },
{ data: 'phone', name: 'phone' },
{ data: 'tag', name: 'tags.name' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-SalesMarket').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection