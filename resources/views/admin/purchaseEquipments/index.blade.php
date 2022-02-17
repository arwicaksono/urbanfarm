@extends('layouts.admin')
@section('content')
@can('purchase_equipment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.purchase-equipments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.purchaseEquipment.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'PurchaseEquipment', 'route' => 'admin.purchase-equipments.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchaseEquipment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-PurchaseEquipment">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.unit_price') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.source') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseEquipment.fields.note') }}
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
@can('purchase_equipment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.purchase-equipments.massDestroy') }}",
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
    ajax: "{{ route('admin.purchase-equipments.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'name', name: 'name' },
{ data: 'quantity', name: 'quantity' },
{ data: 'unit_price', name: 'unit_price' },
{ data: 'source_name', name: 'source.name' },
{ data: 'category_name', name: 'category.name' },
{ data: 'tag', name: 'tags.name' },
{ data: 'status', name: 'statuses.name' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-PurchaseEquipment').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection